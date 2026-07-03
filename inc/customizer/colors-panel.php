<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Customizer: Colors panel
 *
 * General Colors, Colors Dropdown, and Mobile Menu Colors sections.
 * Registered via mec_theme_customize_register() in inc/customizer.php.
 *
 * Extracted from inc/customizer.php during the 1.7.1 file-organization
 * pass. No behavior changed -- this is the same code that used to live
 * inline inside mec_theme_customize_register(), now in its own function.
 *
 * @package MEC_Theme
 * @version 1.7.8
 */
function mec_theme_register_colors_panel( $wp_customize ) {
    
    // === Colors Panel ===
    $wp_customize->add_panel( 'mec_theme_colors_panel', array(
        'title'       => __( 'Colors', 'mec_theme' ),
        'priority'    => 50,
    ) );
    
    // --- General Colors Section ---
    $wp_customize->add_section( 'mec_theme_colors_general_section', array(
        'title'       => __( 'General Colors', 'mec_theme' ),
        'panel'       => 'mec_theme_colors_panel',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_header_bg', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_header_bg', array(
        'label'    => __( 'Header Background', 'mec_theme' ),
        'section'  => 'mec_theme_colors_general_section',
    ) ) );
    
    $wp_customize->add_setting( 'mec_theme_site_title_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_site_title_color', array(
        'label'    => __( 'Site Title Color', 'mec_theme' ),
        'section'  => 'mec_theme_colors_general_section',
    ) ) );
    
    $wp_customize->add_setting( 'mec_theme_site_description_color', array(
        'default'           => '#666666',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_site_description_color', array(
        'label'    => __( 'Site Description Color', 'mec_theme' ),
        'section'  => 'mec_theme_colors_general_section',
    ) ) );
    
    // Tagline Color Control
    $wp_customize->add_setting( 'mec_theme_tagline_color', array(
        'default'           => '#666666',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_tagline_color', array(
        'label'    => __( 'Tagline Color', 'mec_theme' ),
        'section'  => 'mec_theme_colors_general_section',
    ) ) );
    
    $wp_customize->add_setting( 'mec_theme_menu_color', array(
        'default'           => '#3a3a3a',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_menu_color', array(
        'label'    => __( 'Primary Menu Color', 'mec_theme' ),
        'section'  => 'mec_theme_colors_general_section',
    ) ) );
    
    $wp_customize->add_setting( 'mec_theme_heading_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_heading_color', array(
        'label'    => __( 'Heading Color (H1, H2, etc.)', 'mec_theme' ),
        'section'  => 'mec_theme_colors_general_section',
    ) ) );
    
    $wp_customize->add_setting( 'mec_theme_text_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_text_color', array(
        'label'    => __( 'Body Text Color', 'mec_theme' ),
        'section'  => 'mec_theme_colors_general_section',
    ) ) );
    
    $wp_customize->add_setting( 'mec_theme_link_color', array(
        'default'           => '#0274be',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_link_color', array(
        'label'    => __( 'Link Color', 'mec_theme' ),
        'section'  => 'mec_theme_colors_general_section',
    ) ) );
    
    $wp_customize->add_setting( 'mec_theme_link_hover_color', array(
        'default'           => '#3a3a3a',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_link_hover_color', array(
        'label'    => __( 'Link Hover Color', 'mec_theme' ),
        'section'  => 'mec_theme_colors_general_section',
    ) ) );
    
    // --- Dropdown Colors Section ---
    $wp_customize->add_section( 'mec_theme_colors_dropdown_section', array(
        'title'       => __( 'Dropdown Menu Colors', 'mec_theme' ),
        'panel'       => 'mec_theme_colors_panel',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_dropdown_bg', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_dropdown_bg', array(
        'label'    => __( 'Dropdown Menu Background', 'mec_theme' ),
        'section'  => 'mec_theme_colors_dropdown_section',
    ) ) );
    
    $wp_customize->add_setting( 'mec_theme_dropdown_text', array(
        'default'           => '#3a3a3a',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_dropdown_text', array(
        'label'    => __( 'Dropdown Menu Text Color', 'mec_theme' ),
        'section'  => 'mec_theme_colors_dropdown_section',
    ) ) );
    
    $wp_customize->add_setting( 'mec_theme_dropdown_hover_bg', array(
        'default'           => '#f8f9fa',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_dropdown_hover_bg', array(
        'label'    => __( 'Dropdown Menu Hover Background', 'mec_theme' ),
        'section'  => 'mec_theme_colors_dropdown_section',
    ) ) );
    
    $wp_customize->add_setting( 'mec_theme_dropdown_hover_text', array(
        'default'           => '#0274be',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_dropdown_hover_text', array(
        'label'    => __( 'Dropdown Menu Hover Text Color', 'mec_theme' ),
        'section'  => 'mec_theme_colors_dropdown_section',
    ) ) );

    // --- Tablet Menu Colors Section (481px - 768px) ---
    $wp_customize->add_section( 'mec_theme_tablet_menu_colors_section', array(
        'title'       => __( 'Tablet Menu Colors', 'mec_theme' ),
        'description' => __( 'Applies between 481px and 768px wide screens.', 'mec_theme' ),
        'panel'       => 'mec_theme_colors_panel',
        'priority'    => 65,
    ) );

    // Tablet menu background
    $wp_customize->add_setting( 'mec_theme_tablet_menu_bg', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_tablet_menu_bg', array(
        'label'    => __( 'Tablet Menu Background', 'mec_theme' ),
        'section'  => 'mec_theme_tablet_menu_colors_section',
    ) ) );

    // Tablet menu text color
    $wp_customize->add_setting( 'mec_theme_tablet_menu_text', array(
        'default'           => '#3a3a3a',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_tablet_menu_text', array(
        'label'    => __( 'Tablet Menu Text', 'mec_theme' ),
        'section'  => 'mec_theme_tablet_menu_colors_section',
    ) ) );

    // Tablet menu hover background
    $wp_customize->add_setting( 'mec_theme_tablet_menu_hover_bg', array(
        'default'           => '#f8f9fa',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_tablet_menu_hover_bg', array(
        'label'    => __( 'Tablet Menu Hover Background', 'mec_theme' ),
        'section'  => 'mec_theme_tablet_menu_colors_section',
    ) ) );

    // Tablet menu hover text color
    $wp_customize->add_setting( 'mec_theme_tablet_menu_hover_text', array(
        'default'           => '#0274be',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_tablet_menu_hover_text', array(
        'label'    => __( 'Tablet Menu Hover Text', 'mec_theme' ),
        'section'  => 'mec_theme_tablet_menu_colors_section',
    ) ) );

    // Tablet dropdown/submenu background
    $wp_customize->add_setting( 'mec_theme_tablet_dropdown_bg', array(
        'default'           => '#f9f9f9',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_tablet_dropdown_bg', array(
        'label'    => __( 'Tablet Dropdown Background', 'mec_theme' ),
        'section'  => 'mec_theme_tablet_menu_colors_section',
    ) ) );

    // Tablet dropdown/submenu text
    $wp_customize->add_setting( 'mec_theme_tablet_dropdown_text', array(
        'default'           => '#3a3a3a',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_tablet_dropdown_text', array(
        'label'    => __( 'Tablet Dropdown Text', 'mec_theme' ),
        'section'  => 'mec_theme_tablet_menu_colors_section',
    ) ) );

    // Tablet dropdown/submenu hover background
    $wp_customize->add_setting( 'mec_theme_tablet_dropdown_hover_bg', array(
        'default'           => '#f8f9fa',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_tablet_dropdown_hover_bg', array(
        'label'    => __( 'Tablet Dropdown Hover Background', 'mec_theme' ),
        'section'  => 'mec_theme_tablet_menu_colors_section',
    ) ) );

    // Tablet dropdown/submenu hover text
    $wp_customize->add_setting( 'mec_theme_tablet_dropdown_hover_text', array(
        'default'           => '#0274be',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_tablet_dropdown_hover_text', array(
        'label'    => __( 'Tablet Dropdown Hover Text', 'mec_theme' ),
        'section'  => 'mec_theme_tablet_menu_colors_section',
    ) ) );

    // Tablet dropdown/submenu divider color
    $wp_customize->add_setting( 'mec_theme_tablet_dropdown_border', array(
        'default'           => '#e0e0e0',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_tablet_dropdown_border', array(
        'label'    => __( 'Tablet Dropdown Divider Color', 'mec_theme' ),
        'section'  => 'mec_theme_tablet_menu_colors_section',
    ) ) );

    // --- Mobile Menu Colors Section (480px and below) ---
    $wp_customize->add_section( 'mec_theme_mobile_menu_colors_section', array(
        'title'       => __( 'Mobile Menu Colors', 'mec_theme' ),
        'description' => __( 'Applies at 480px wide and below. Also includes the hamburger button and close (X) button, which are shared across tablet and mobile.', 'mec_theme' ),
        'panel'       => 'mec_theme_colors_panel',
        'priority'    => 70,
    ) );

    // Mobile menu background
    $wp_customize->add_setting( 'mec_theme_mobile_menu_bg', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_mobile_menu_bg', array(
        'label'    => __( 'Mobile Menu Background', 'mec_theme' ),
        'section'  => 'mec_theme_mobile_menu_colors_section',
    ) ) );

    // Mobile menu text color
    $wp_customize->add_setting( 'mec_theme_mobile_menu_text', array(
        'default'           => '#3a3a3a',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_mobile_menu_text', array(
        'label'    => __( 'Mobile Menu Text', 'mec_theme' ),
        'section'  => 'mec_theme_mobile_menu_colors_section',
    ) ) );

    // Mobile menu hover background
    $wp_customize->add_setting( 'mec_theme_mobile_menu_hover_bg', array(
        'default'           => '#f8f9fa',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_mobile_menu_hover_bg', array(
        'label'    => __( 'Mobile Menu Hover Background', 'mec_theme' ),
        'section'  => 'mec_theme_mobile_menu_colors_section',
    ) ) );

    // Mobile menu hover text color
    $wp_customize->add_setting( 'mec_theme_mobile_menu_hover_text', array(
        'default'           => '#0274be',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_mobile_menu_hover_text', array(
        'label'    => __( 'Mobile Menu Hover Text', 'mec_theme' ),
        'section'  => 'mec_theme_mobile_menu_colors_section',
    ) ) );

    // Mobile dropdown/submenu background
    $wp_customize->add_setting( 'mec_theme_mobile_dropdown_bg', array(
        'default'           => '#f9f9f9',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_mobile_dropdown_bg', array(
        'label'    => __( 'Mobile Dropdown Background', 'mec_theme' ),
        'section'  => 'mec_theme_mobile_menu_colors_section',
    ) ) );

    // Mobile dropdown/submenu text
    $wp_customize->add_setting( 'mec_theme_mobile_dropdown_text', array(
        'default'           => '#3a3a3a',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_mobile_dropdown_text', array(
        'label'    => __( 'Mobile Dropdown Text', 'mec_theme' ),
        'section'  => 'mec_theme_mobile_menu_colors_section',
    ) ) );

    // Mobile dropdown/submenu hover background
    $wp_customize->add_setting( 'mec_theme_mobile_dropdown_hover_bg', array(
        'default'           => '#f8f9fa',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_mobile_dropdown_hover_bg', array(
        'label'    => __( 'Mobile Dropdown Hover Background', 'mec_theme' ),
        'section'  => 'mec_theme_mobile_menu_colors_section',
    ) ) );

    // Mobile dropdown/submenu hover text
    $wp_customize->add_setting( 'mec_theme_mobile_dropdown_hover_text', array(
        'default'           => '#0274be',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_mobile_dropdown_hover_text', array(
        'label'    => __( 'Mobile Dropdown Hover Text', 'mec_theme' ),
        'section'  => 'mec_theme_mobile_menu_colors_section',
    ) ) );

    // Mobile dropdown/submenu divider color
    $wp_customize->add_setting( 'mec_theme_mobile_dropdown_border', array(
        'default'           => '#e0e0e0',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_mobile_dropdown_border', array(
        'label'    => __( 'Mobile Dropdown Divider Color', 'mec_theme' ),
        'section'  => 'mec_theme_mobile_menu_colors_section',
    ) ) );

    // === HAMBURGER BUTTON COLORS (with transparent support) ===
    $wp_customize->add_setting( 'mec_theme_hamburger_bg', array(
        'default'           => 'transparent',
        'sanitize_callback' => 'mec_theme_sanitize_color_transparent',
    ) );
    $wp_customize->add_control( 'mec_theme_hamburger_bg', array(
        'label'       => __( 'Hamburger Button Background', 'mec_theme' ),
        'section'     => 'mec_theme_mobile_menu_colors_section',
        'type'        => 'text',
        'description' => esc_html__( 'Use "transparent" or a hex color like #ff0000', 'mec_theme' ),
    ) );

    $wp_customize->add_setting( 'mec_theme_hamburger_color', array(
        'default'           => '#3a3a3a',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_hamburger_color', array(
        'label'    => __( 'Hamburger Icon Color', 'mec_theme' ),
        'section'  => 'mec_theme_mobile_menu_colors_section',
    ) ) );

    $wp_customize->add_setting( 'mec_theme_hamburger_hover_bg', array(
        'default'           => 'transparent',
        'sanitize_callback' => 'mec_theme_sanitize_color_transparent',
    ) );
    $wp_customize->add_control( 'mec_theme_hamburger_hover_bg', array(
        'label'       => __( 'Hamburger Button Hover Background', 'mec_theme' ),
        'section'     => 'mec_theme_mobile_menu_colors_section',
        'type'        => 'text',
        'description' => esc_html__( 'Use "transparent" or a hex color like #ff0000', 'mec_theme' ),
    ) );

    $wp_customize->add_setting( 'mec_theme_hamburger_hover_color', array(
        'default'           => '#0274be',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_hamburger_hover_color', array(
        'label'    => __( 'Hamburger Icon Hover Color', 'mec_theme' ),
        'section'  => 'mec_theme_mobile_menu_colors_section',
    ) ) );

    // === MOBILE CLOSE BUTTON (X) COLORS ===
    $wp_customize->add_setting( 'mec_theme_mobile_close_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_mobile_close_color', array(
        'label'    => __( 'Mobile Close Button (X) Color', 'mec_theme' ),
        'section'  => 'mec_theme_mobile_menu_colors_section',
    ) ) );

    $wp_customize->add_setting( 'mec_theme_mobile_close_hover_color', array(
        'default'           => '#0274be',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_mobile_close_hover_color', array(
        'label'    => __( 'Mobile Close Button Hover Color', 'mec_theme' ),
        'section'  => 'mec_theme_mobile_menu_colors_section',
    ) ) );
    
}
