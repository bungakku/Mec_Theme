<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Whitelist sanitizers and validators used by every Customizer setting
 * in this theme. Kept in one file so it's easy to audit: every select/radio
 * control's sanitize_callback should resolve to a function defined here.
 *
 * Extracted from functions.php and inc/customizer.php during the 1.7.1
 * file-organization pass.
 *
 * @package MEC_Theme
 */

/**
 * Sanitization function for text alignment
 */
function mec_theme_sanitize_text_align( $input ) {
    $valid = array( 'left', 'center', 'right' );
    return in_array( $input, $valid, true ) ? $input : 'left';
}

/**
 * Sanitization functions
 */
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

/**
 * Whitelist sanitizers for font family selects.
 * Must mirror the 'choices' arrays on the matching add_control() calls exactly,
 * since these values are later concatenated directly into a <style> block.
 */
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

/**
 * Sanitize color or 'transparent'
 */
function mec_theme_sanitize_color_transparent( $input ) {
    if ( 'transparent' === $input ) {
        return 'transparent';
    }
    return sanitize_hex_color( $input );
}

/**
 * Validate that content width + sidebar width does not exceed 100%
 */
function mec_theme_validate_layout_widths( $validity, $value, $setting ) {
    // Only validate the two width settings
    if ( ! in_array( $setting->id, array( 'mec_theme_content_width', 'mec_theme_sidebar_width' ), true ) ) {
        return $validity;
    }

    // Get the other setting's value (as it will be after saving)
    $content_width = get_theme_mod( 'mec_theme_content_width', 75 );
    $sidebar_width = get_theme_mod( 'mec_theme_sidebar_width', 22 );

    // If the current setting is being updated, use the new value
    if ( 'mec_theme_content_width' === $setting->id ) {
        $content_width = $value;
    } else {
        $sidebar_width = $value;
    }

    if ( ( $content_width + $sidebar_width ) > 100 ) {
        $validity->add( 'width_exceeds_limit', __( 'Content width and sidebar width must not exceed 100%. Please adjust your values.', 'mec_theme' ) );
    }

    return $validity;
}
add_filter( 'customize_validate_setting', 'mec_theme_validate_layout_widths', 10, 3 );
