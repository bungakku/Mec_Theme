<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Customizer Settings - Orchestrator
 *
 * This file pulls in every Customizer panel and registers them against
 * mec_theme_customize_register(), which fires on the customize_register hook.
 *
 * Extracted/reorganized during the 1.7.4 file-organization pass. No behavior
 * changed: every add_panel/add_section/add_setting/add_control call that
 * used to live inline in this file is now in inc/customizer/{name}-panel.php,
 * each wrapped in its own mec_theme_register_{name}_panel() function. This
 * file just requires those files and calls each function in the same order
 * the panels used to appear, so panel priorities and registration order are
 * unchanged.
 *
 * inc/customizer/contact-social-panel.php is self-registering (it has its
 * own add_action( 'customize_register', ... ) calls, same as it did when it
 * lived in functions.php), so it only needs to be required here, not called.
 *
 * @package MEC_Theme
 * @version 1.7.4
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
