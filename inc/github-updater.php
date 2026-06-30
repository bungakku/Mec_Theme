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
 * - Tag the release on GitHub as `vX.Y.Z` (e.g. v1.7.7), matching the
 *   `Version:` header in style.css (without the leading "v").
 * - Publish it as a GitHub Release (not just a tag) so it has a downloadable
 *   zip asset, which is what this file fetches.
 *
 * This file only checks for and facilitates installing updates. It does not
 * modify, override, or interfere with any existing theme behaviour, styling,
 * or Customizer functionality in any way.
 *
 * @package MEC_Theme
 * @version 1.7.7
 */

/**
 * Where to check. Change these two constants if the theme ever moves to a
 * different GitHub repository.
 */
if ( ! defined( 'MEC_THEME_GITHUB_OWNER' ) ) {
    define( 'MEC_THEME_GITHUB_OWNER', 'bungakku' );
}
if ( ! defined( 'MEC_THEME_GITHUB_REPO' ) ) {
    define( 'MEC_THEME_GITHUB_REPO', 'Mec_Theme' );
}

/**
 * Fetch the latest release info from GitHub, cached for 12 hours.
 *
 * Caching matters for two reasons: GitHub's API is rate-limited for
 * unauthenticated requests (60/hour per IP), and there's no reason to make a
 * fresh network request on every single admin page load.
 *
 * @return array|false Associative array with 'version', 'download_url',
 *                      'changelog_url', 'body' on success, false on failure.
 */
function mec_theme_get_latest_github_release() {
    $cached = get_site_transient( 'mec_theme_github_release' );
    if ( false !== $cached ) {
        return $cached;
    }

    $api_url = sprintf(
        'https://api.github.com/repos/%s/%s/releases/latest',
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
        // Cache the failure briefly too, so a broken connection doesn't
        // mean a GitHub API call on every page load.
        set_site_transient( 'mec_theme_github_release', false, HOUR_IN_SECONDS );
        return false;
    }

    $body = json_decode( wp_remote_retrieve_body( $response ), true );

    if ( empty( $body['tag_name'] ) || empty( $body['zipball_url'] ) ) {
        set_site_transient( 'mec_theme_github_release', false, HOUR_IN_SECONDS );
        return false;
    }

    // Tags are expected as "v1.7.7"; strip the leading "v" to compare
    // against the plain "1.7.7" used in style.css's Version: header.
    $version = preg_replace( '/^v/i', '', $body['tag_name'] );

    // Prefer an explicitly-attached release zip asset over GitHub's
    // auto-generated source zipball, if one was uploaded, since an
    // uploaded asset can be named/structured deliberately. Fall back to
    // the zipball (always present for any published release) otherwise.
    $download_url = $body['zipball_url'];
    if ( ! empty( $body['assets'] ) && is_array( $body['assets'] ) ) {
        foreach ( $body['assets'] as $asset ) {
            if ( ! empty( $asset['browser_download_url'] ) && preg_match( '/\.zip$/i', $asset['name'] ) ) {
                $download_url = $asset['browser_download_url'];
                break;
            }
        }
    }

    $release = array(
        'version'       => sanitize_text_field( $version ),
        'download_url'  => esc_url_raw( $download_url ),
        'changelog_url' => esc_url_raw( ! empty( $body['html_url'] ) ? $body['html_url'] : '' ),
        'body'          => isset( $body['body'] ) ? wp_kses_post( $body['body'] ) : '',
    );

    set_site_transient( 'mec_theme_github_release', $release, 12 * HOUR_IN_SECONDS );

    return $release;
}

/**
 * Hook into WordPress's own theme-update check.
 *
 * This filter runs whenever WordPress is about to cache its list of
 * available theme updates (on the Updates/Themes screens, and periodically
 * in the background) -- it fires before the transient is written, which is
 * the correct point to inject data into it (as opposed to a get-side filter,
 * which would run on every read and is the wrong tool for this job). If
 * GitHub has a newer version than what's installed, we add an entry here --
 * this is the exact same transient WordPress.org-hosted themes use, so the
 * resulting "Update available" notice and "Update now" button behave
 * identically to a normal theme update.
 */
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
        // Populating no_update (WP 5.5+) is what makes the auto-update
        // enable/disable links appear correctly for a theme that isn't
        // hosted on WordPress.org, even when it's already up to date.
        $transient->no_update[ $stylesheet ] = $item;
        unset( $transient->response[ $stylesheet ] );
    }

    return $transient;
}
add_filter( 'pre_set_site_transient_update_themes', 'mec_theme_check_for_update' );

/**
 * Fix the extracted folder name during install/update.
 *
 * GitHub's zip (whether the auto-generated zipball or a manually uploaded
 * asset built the same way) typically extracts to a folder named after the
 * repo and commit/tag, e.g. "bungakku-Mec_Theme-abc1234" -- not the theme's
 * actual slug. Without this, WordPress's upgrader can fail to recognise the
 * update target, or install the theme into a wrongly-named new folder
 * alongside the original instead of updating it in place.
 *
 * This renames the extracted source folder to match the currently
 * installed theme's slug before WordPress moves it into wp-content/themes.
 *
 * @param string      $source        File source location (the extracted folder).
 * @param string      $remote_source Remote file source location (its parent dir).
 * @param WP_Upgrader $upgrader      WP_Upgrader instance.
 * @param array       $hook_extra    Extra args; for a theme update this contains
 *                                   'theme' (the stylesheet slug), 'type', 'action'.
 */
function mec_theme_fix_github_zip_folder_name( $source, $remote_source, $upgrader, $hook_extra ) {
    global $wp_filesystem;

    // Only act on this theme's own update; never touch any other
    // theme or plugin update in progress.
    if ( empty( $hook_extra['theme'] ) || get_stylesheet() !== $hook_extra['theme'] ) {
        return $source;
    }

    $correct_slug = get_stylesheet();
    $desired_path = trailingslashit( $remote_source ) . $correct_slug;

    // Already correctly named (e.g. a manually uploaded asset built with
    // the right folder structure) -- nothing to do.
    if ( untrailingslashit( $source ) === untrailingslashit( $desired_path ) ) {
        return $source;
    }

    // move_dir() (WP 6.2+) uses rename() with a proper recursive-copy
    // fallback for directories, and handles OPcache invalidation. The
    // plain $wp_filesystem->move() method's fallback only ever works for
    // single files, not directories, so it isn't reliable here.
    if ( function_exists( 'move_dir' ) ) {
        $moved = move_dir( $source, $desired_path );
        if ( ! is_wp_error( $moved ) && $moved ) {
            return trailingslashit( $desired_path );
        }
        return $source;
    }

    // Fallback for WordPress installs older than 6.2: copy recursively,
    // then remove the original extracted folder.
    if ( ! $wp_filesystem->exists( $desired_path ) ) {
        $wp_filesystem->mkdir( $desired_path );
    }
    $copied = copy_dir( $source, $desired_path );
    if ( ! is_wp_error( $copied ) ) {
        $wp_filesystem->delete( $source, true );
        return trailingslashit( $desired_path );
    }

    // If neither approach works, return the original source. WordPress's
    // own upgrader will then surface its normal error to the admin rather
    // than this function silently producing a broken result.
    return $source;
}
add_filter( 'upgrader_source_selection', 'mec_theme_fix_github_zip_folder_name', 10, 4 );

/**
 * Clear the cached release info immediately after an update completes, so
 * the "Update available" notice doesn't linger stale if checked again right
 * away, and after a manual "Check again" on the Updates screen.
 */
function mec_theme_clear_github_release_cache() {
    delete_site_transient( 'mec_theme_github_release' );
}
add_action( 'upgrader_process_complete', 'mec_theme_clear_github_release_cache', 10, 0 );
add_action( 'load-update-core.php', 'mec_theme_clear_github_release_cache_on_check_again' );

/**
 * "Check again" on the Updates screen should bypass the 12-hour cache, not
 * just WordPress's own update transient -- otherwise clicking it could
 * still show stale GitHub data for up to 12 hours.
 */
function mec_theme_clear_github_release_cache_on_check_again() {
    if ( isset( $_GET['force-check'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        delete_site_transient( 'mec_theme_github_release' );
    }
}
