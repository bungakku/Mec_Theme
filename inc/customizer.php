<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Customizer Settings - Orchestrator
 *
 * @package MEC_Theme
 */

require_once MEC_THEME_DIR . '/inc/customizer/layout-panel.php';
require_once MEC_THEME_DIR . '/inc/customizer/typography-panel.php';
require_once MEC_THEME_DIR . '/inc/customizer/colors-panel.php';
require_once MEC_THEME_DIR . '/inc/customizer/blog-panel.php';
require_once MEC_THEME_DIR . '/inc/customizer/contact-social-panel.php';

function mec_theme_customize_register( $wp_customize ) {
    mec_theme_register_layout_panel( $wp_customize );
    mec_theme_register_typography_panel( $wp_customize );
    mec_theme_register_colors_panel( $wp_customize );
    mec_theme_register_blog_panel( $wp_customize );
}
add_action( 'customize_register', 'mec_theme_customize_register' );
