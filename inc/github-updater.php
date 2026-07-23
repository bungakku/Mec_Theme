<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * GitHub-based update checker for MEC_Theme.
 *
 * This theme isn't distributed via WordPress.org, so WordPress has no
 * built-in way to know a new version exists. This file hooks into the same
 * update-checking system WordPress.org themes use, but points it at GitHub
 * Releases instead: https://github.com/bungakku/Mec_Theme/releases
 *
 * What this gives a site running this theme:
 * - The normal "Update available" notice on Appearance > Themes and on the
 *   Updates screen, with a real version number and changelog link.
 * - A working "Update now" button that downloads and installs the new
 *   version exactly the way a WordPress.org theme update would.
 *
 * What this requires going forward, for every future release:
 * - Tag the release on GitHub as `vX.Y.Z` (e.g. v1.7.8), matching the
 *   `Version:` header in style.css (without the leading "v").
 * - Publish it as a GitHub Release (not just a tag) so it has a downloadable
 *   zip asset, which is what this file fetches.
 *
 * This file only checks for and facilitates installing updates. It does not
 * modify, override, or interfere with any existing theme behaviour, styling,
 * or Customizer functionality in any way.
 *
 * @package MEC_Theme
 */

if ( ! defined( 'MEC_THEME_GITHUB_OWNER' ) ) {
    define( 'MEC_THEME_GITHUB_OWNER', 'bungakku' );
}
if ( ! defined( 'MEC_THEME_GITHUB_REPO' ) ) {
    define( 'MEC_THEME_GITHUB_REPO', 'Mec_Theme' );
}

function mec_theme_get_latest_github_release() {
    $cached = get_site_transient( 'mec_theme_github_release' );
    if ( false !== $cached ) {
        return $cached;
    }

    $api_url = sprintf(
        'https://api.github.com/repos/%s/%s/releases?per_page=20',
        MEC_THEME_GITHUB_OWNER,
        MEC_THEME_GITHUB_REPO
    );

    $response = wp_remote_get( $api_url, array(
        'timeout' => 10,
        'headers' => array(
            'Accept'     => 'application/vnd.github+json',
            'User-Agent' => 'MEC_Theme-Updater',
        ),
    ) );

    if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
        set_site_transient( 'mec_theme_github_release', false, HOUR_IN_SECONDS );
        return false;
    }

    $releases = json_decode( wp_remote_retrieve_body( $response ), true );

    if ( empty( $releases ) || ! is_array( $releases ) ) {
        set_site_transient( 'mec_theme_github_release', false, HOUR_IN_SECONDS );
        return false;
    }

    $best_version = null;
    $best_release = null;

    foreach ( $releases as $candidate ) {
        if ( ! empty( $candidate['draft'] ) || ! empty( $candidate['prerelease'] ) ) {
            continue;
        }
        if ( empty( $candidate['tag_name'] ) || empty( $candidate['zipball_url'] ) ) {
            continue;
        }

        $candidate_version = preg_replace( '/^v/i', '', $candidate['tag_name'] );

        if ( ! preg_match( '/^\d+(\.\d+)*$/', $candidate_version ) ) {
            continue;
        }

        if ( null === $best_version || version_compare( $candidate_version, $best_version, '>' ) ) {
            $best_version = $candidate_version;
            $best_release = $candidate;
        }
    }

    if ( null === $best_release ) {
        set_site_transient( 'mec_theme_github_release', false, HOUR_IN_SECONDS );
        return false;
    }

    $download_url = $best_release['zipball_url'];
    if ( ! empty( $best_release['assets'] ) && is_array( $best_release['assets'] ) ) {
        foreach ( $best_release['assets'] as $asset ) {
            if ( ! empty( $asset['browser_download_url'] ) && preg_match( '/\.zip$/i', $asset['name'] ) ) {
                $download_url = $asset['browser_download_url'];
                break;
            }
        }
    }

    $release = array(
        'version'       => sanitize_text_field( $best_version ),
        'download_url'  => esc_url_raw( $download_url ),
        'changelog_url' => esc_url_raw( ! empty( $best_release['html_url'] ) ? $best_release['html_url'] : '' ),
    );

    set_site_transient( 'mec_theme_github_release', $release, 12 * HOUR_IN_SECONDS );

    return $release;
}

function mec_theme_check_for_update( $transient ) {
    if ( empty( $transient->checked ) ) {
        return $transient;
    }

    $stylesheet = get_stylesheet();
    $current_version = wp_get_theme( $stylesheet )->get( 'Version' );

    $release = mec_theme_get_latest_github_release();
    if ( false === $release ) {
        return $transient;
    }

    $item = array(
        'theme'       => $stylesheet,
        'new_version' => $release['version'],
        'url'         => $release['changelog_url'] ? $release['changelog_url'] : 'https://github.com/' . MEC_THEME_GITHUB_OWNER . '/' . MEC_THEME_GITHUB_REPO,
        'package'     => $release['download_url'],
    );

    if ( version_compare( $release['version'], $current_version, '>' ) ) {
        $transient->response[ $stylesheet ] = $item;
        unset( $transient->no_update[ $stylesheet ] );
    } else {
        $transient->no_update[ $stylesheet ] = $item;
        unset( $transient->response[ $stylesheet ] );
    }

    return $transient;
}
add_filter( 'pre_set_site_transient_update_themes', 'mec_theme_check_for_update' );

function mec_theme_fix_github_zip_folder_name( $source, $remote_source, $upgrader, $hook_extra ) {
    global $wp_filesystem;

    if ( empty( $hook_extra['theme'] ) || get_stylesheet() !== $hook_extra['theme'] ) {
        return $source;
    }

    $correct_slug = get_stylesheet();
    $desired_path = trailingslashit( $remote_source ) . $correct_slug;

    if ( untrailingslashit( $source ) === untrailingslashit( $desired_path ) ) {
        return $source;
    }

    if ( function_exists( 'move_dir' ) ) {
        $moved = move_dir( $source, $desired_path );
        if ( ! is_wp_error( $moved ) && $moved ) {
            return trailingslashit( $desired_path );
        }
        return $source;
    }

    if ( ! $wp_filesystem->exists( $desired_path ) ) {
        $wp_filesystem->mkdir( $desired_path );
    }
    $copied = copy_dir( $source, $desired_path );
    if ( ! is_wp_error( $copied ) ) {
        $wp_filesystem->delete( $source, true );
        return trailingslashit( $desired_path );
    }

    return $source;
}
add_filter( 'upgrader_source_selection', 'mec_theme_fix_github_zip_folder_name', 10, 4 );

function mec_theme_clear_github_release_cache() {
    delete_site_transient( 'mec_theme_github_release' );
}
add_action( 'upgrader_process_complete', 'mec_theme_clear_github_release_cache', 10, 0 );
add_action( 'load-update-core.php', 'mec_theme_clear_github_release_cache_on_check_again' );

function mec_theme_clear_github_release_cache_on_check_again() {
    if ( isset( $_GET['force-check'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        delete_site_transient( 'mec_theme_github_release' );
    }
}
