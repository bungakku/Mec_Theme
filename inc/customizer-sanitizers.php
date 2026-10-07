<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Whitelist sanitizers and validators used by every Customizer setting
 * in this theme.
 *
 * @package MEC_Theme
 */

function mec_theme_sanitize_text_align( $input ) {
    $valid = array( 'left', 'center', 'right' );
    return in_array( $input, $valid, true ) ? $input : 'left';
}

function mec_theme_sanitize_sidebar_position( $input ) {
    $valid = array( 'left', 'right' );
    return in_array( $input, $valid, true ) ? $input : 'right';
}

function mec_theme_sanitize_logo_position( $input ) {
    $valid = array( 'left', 'right', 'top', 'bottom' );
    return in_array( $input, $valid, true ) ? $input : 'left';
}

function mec_theme_sanitize_footer_columns( $input ) {
    $valid = array( '1', '2', '3', '4' );
    return in_array( $input, $valid, true ) ? $input : '4';
}

function mec_theme_sanitize_footer_direction( $input ) {
    $valid = array( 'horizontal', 'vertical' );
    return in_array( $input, $valid, true ) ? $input : 'horizontal';
}

function mec_theme_sanitize_float( $input ) {
    return floatval( $input );
}

function mec_theme_sanitize_blog_layout( $input ) {
    $valid = array( 'classic', 'grid', 'list' );
    return in_array( $input, $valid, true ) ? $input : 'classic';
}

function mec_theme_sanitize_body_font_family( $input ) {
    $valid = array(
        'default',
        'Arial, sans-serif',
        'Helvetica, sans-serif',
        'Verdana, sans-serif',
        'Tahoma, sans-serif',
        '"Trebuchet MS", sans-serif',
        'Georgia, serif',
        '"Times New Roman", serif',
        'Palatino, serif',
        '"Courier New", monospace',
        '"Comic Sans MS", cursive',
    );
    return in_array( $input, $valid, true ) ? $input : 'default';
}

function mec_theme_sanitize_heading_font_family( $input ) {
    $valid = array(
        'default',
        'Arial, sans-serif',
        'Helvetica, sans-serif',
        'Verdana, sans-serif',
        'Tahoma, sans-serif',
        '"Trebuchet MS", sans-serif',
        'Georgia, serif',
        '"Times New Roman", serif',
        'Palatino, serif',
        '"Courier New", monospace',
        'Impact, sans-serif',
    );
    return in_array( $input, $valid, true ) ? $input : 'default';
}

function mec_theme_sanitize_grid_columns( $input ) {
    $valid = array( '2', '3', '4' );
    return in_array( $input, $valid, true ) ? $input : '2';
}

function mec_theme_sanitize_show_hide( $input ) {
    $valid = array( 'show', 'hide' );
    return in_array( $input, $valid, true ) ? $input : 'show';
}

function mec_theme_sanitize_image_size( $input ) {
    $valid = array( 'thumbnail', 'medium', 'large', 'full' );
    return in_array( $input, $valid, true ) ? $input : 'large';
}

function mec_theme_sanitize_post_meta( $input ) {
    $valid = array( 'show', 'hide', 'custom' );
    return in_array( $input, $valid, true ) ? $input : 'show';
}

function mec_theme_sanitize_content_display( $input ) {
    $valid = array( 'excerpt', 'full', 'none' );
    return in_array( $input, $valid, true ) ? $input : 'excerpt';
}

function mec_theme_sanitize_color_transparent( $input ) {
    if ( 'transparent' === $input ) {
        return 'transparent';
    }
    return sanitize_hex_color( $input );
}

/**
 * Customizer validate_callback for the header email address.
 *
 * Added in 1.7.70. An empty value is allowed (header.php hides the email
 * block when it is empty). Anything else must be a valid email address.
 * Without this, sanitize_email() silently reduced an invalid entry to an
 * empty string -- or quietly rewrote it ("a b@c.com" became "ab@c.com") --
 * at save time, so the field just appeared not to save.
 */
function mec_theme_validate_email( $validity, $value ) {
    $value = trim( (string) $value );
    if ( '' !== $value && ! is_email( $value ) ) {
        $validity->add( 'invalid_email', __( 'Please enter a valid email address.', 'mec_theme' ) );
    }
    return $validity;
}

/**
 * Customizer validate_callback for the header social profile URLs.
 *
 * Added in 1.7.70. An empty value is allowed (the icon is simply not
 * rendered). Anything else must be an http:// or https:// URL with a host
 * containing a dot and no whitespace. Previously esc_url_raw() accepted
 * almost anything: "hello world" was saved as "http://hello%20world", and
 * mailto:/ftp: links were accepted as "social" URLs. Already-saved values
 * are unaffected -- validation only runs when a value is changed.
 */
function mec_theme_validate_url( $validity, $value ) {
    $value = trim( (string) $value );
    if ( '' === $value ) {
        return $validity;
    }
    $host = wp_parse_url( $value, PHP_URL_HOST );
    if ( ! preg_match( '#^https?://#i', $value ) || preg_match( '/\s/', $value ) || empty( $host ) || false === strpos( $host, '.' ) ) {
        $validity->add( 'invalid_url', __( 'Please enter a valid URL starting with http:// or https://.', 'mec_theme' ) );
    }
    return $validity;
}

/**
 * Customizer validate_callback: main content width + sidebar width must not
 * exceed 100%.
 *
 * Fixed in 1.7.71. This function was hooked with
 * add_filter( 'customize_validate_setting', ... ), which is not a WordPress
 * hook (core only fires "customize_validate_{$setting_id}"), so it never ran
 * and a 112% layout could be published. It is now attached as the
 * validate_callback of both settings in inc/customizer/layout-panel.php.
 *
 * The other setting's value is read from the same save request when it is
 * also being changed, falling back to its current effective value otherwise
 * -- so editing both fields at once is judged on the pair actually about to
 * be saved, not on a stale stored value. It reads unsanitized_post_values()
 * directly rather than $other->post_value(): post_value() validates the
 * value it returns, which would re-enter this callback for the other
 * setting and recurse endlessly whenever both fields carry pending values.
 */
function mec_theme_validate_layout_widths( $validity, $value, $setting ) {
    if ( 'mec_theme_content_width' === $setting->id ) {
        $other_id = 'mec_theme_sidebar_width';
    } elseif ( 'mec_theme_sidebar_width' === $setting->id ) {
        $other_id = 'mec_theme_content_width';
    } else {
        return $validity;
    }

    $post_values = $setting->manager->unsanitized_post_values();
    if ( array_key_exists( $other_id, $post_values ) ) {
        $other_value = $post_values[ $other_id ];
    } else {
        $other       = $setting->manager->get_setting( $other_id );
        $other_value = $other ? $other->value() : get_theme_mod( $other_id );
    }

    if ( ( absint( $value ) + absint( $other_value ) ) > 100 ) {
        $validity->add( 'width_exceeds_limit', __( 'Content width and sidebar width must not exceed 100%. Please adjust your values.', 'mec_theme' ) );
    }

    return $validity;
}
