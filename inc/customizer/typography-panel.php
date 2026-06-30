<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Customizer: Typography panel
 *
 * Font Family, Font Sizes (desktop/tablet/mobile), and Submenu & Hamburger sections.
 * Registered via mec_theme_customize_register() in inc/customizer.php.
 *
 * Extracted from inc/customizer.php during the 1.7.7 file-organization
 * pass. No behavior changed -- this is the same code that used to live
 * inline inside mec_theme_customize_register(), now in its own function.
 *
 * @package MEC_Theme
 * @version 1.7.7
 */
function mec_theme_register_typography_panel( $wp_customize ) {
    
    // === Typography Panel ===
    $wp_customize->add_panel( 'mec_theme_typography_panel', array(
        'title'       => __( 'Typography', 'mec_theme' ),
        'priority'    => 40,
        'description' => __( 'Customize fonts for different devices. Desktop > 768px, Tablet: 481-768px, Mobile: ≤ 480px', 'mec_theme' ),
    ) );
    
    // --- Font Family Section ---
    $wp_customize->add_section( 'mec_theme_font_family_section', array(
        'title'       => __( 'Font Family', 'mec_theme' ),
        'panel'       => 'mec_theme_typography_panel',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_body_font_family', array(
        'default'           => 'default',
        'sanitize_callback' => 'mec_theme_sanitize_body_font_family',
    ) );
    $wp_customize->add_control( 'mec_theme_body_font_family', array(
        'label'       => __( 'Body Font Family', 'mec_theme' ),
        'section'     => 'mec_theme_font_family_section',
        'type'        => 'select',
        'choices'     => array(
            'default'      => __( 'System Default', 'mec_theme' ),
            'Arial, sans-serif' => __( 'Arial', 'mec_theme' ),
            'Helvetica, sans-serif' => __( 'Helvetica', 'mec_theme' ),
            'Verdana, sans-serif' => __( 'Verdana', 'mec_theme' ),
            'Tahoma, sans-serif' => __( 'Tahoma', 'mec_theme' ),
            '"Trebuchet MS", sans-serif' => __( 'Trebuchet MS', 'mec_theme' ),
            'Georgia, serif' => __( 'Georgia', 'mec_theme' ),
            '"Times New Roman", serif' => __( 'Times New Roman', 'mec_theme' ),
            'Palatino, serif' => __( 'Palatino', 'mec_theme' ),
            '"Courier New", monospace' => __( 'Courier New', 'mec_theme' ),
            '"Comic Sans MS", cursive' => __( 'Comic Sans', 'mec_theme' ),
        ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_heading_font_family', array(
        'default'           => 'default',
        'sanitize_callback' => 'mec_theme_sanitize_heading_font_family',
    ) );
    $wp_customize->add_control( 'mec_theme_heading_font_family', array(
        'label'       => __( 'Heading Font Family', 'mec_theme' ),
        'section'     => 'mec_theme_font_family_section',
        'type'        => 'select',
        'choices'     => array(
            'default'      => __( 'Same as Body', 'mec_theme' ),
            'Arial, sans-serif' => __( 'Arial', 'mec_theme' ),
            'Helvetica, sans-serif' => __( 'Helvetica', 'mec_theme' ),
            'Verdana, sans-serif' => __( 'Verdana', 'mec_theme' ),
            'Tahoma, sans-serif' => __( 'Tahoma', 'mec_theme' ),
            '"Trebuchet MS", sans-serif' => __( 'Trebuchet MS', 'mec_theme' ),
            'Georgia, serif' => __( 'Georgia', 'mec_theme' ),
            '"Times New Roman", serif' => __( 'Times New Roman', 'mec_theme' ),
            'Palatino, serif' => __( 'Palatino', 'mec_theme' ),
            '"Courier New", monospace' => __( 'Courier New', 'mec_theme' ),
            'Impact, sans-serif' => __( 'Impact', 'mec_theme' ),
        ),
    ) );
    
    // --- Desktop Font Sizes ---
    $wp_customize->add_section( 'mec_theme_font_size_desktop_section', array(
        'title'       => __( 'Desktop Sizes (>768px)', 'mec_theme' ),
        'panel'       => 'mec_theme_typography_panel',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_body_font_size_desktop', array(
        'default'           => 16,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'mec_theme_body_font_size_desktop', array(
        'label'       => __( 'Body Font Size (px)', 'mec_theme' ),
        'section'     => 'mec_theme_font_size_desktop_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 12, 'max' => 24, 'step' => 1 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_site_title_size_desktop', array(
        'default'           => '1.8',
        'sanitize_callback' => 'mec_theme_sanitize_float',
    ) );
    $wp_customize->add_control( 'mec_theme_site_title_size_desktop', array(
        'label'       => __( 'Site Title Font Size (rem)', 'mec_theme' ),
        'section'     => 'mec_theme_font_size_desktop_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 1, 'max' => 4, 'step' => 0.1 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_tagline_size_desktop', array(
        'default'           => '1',
        'sanitize_callback' => 'mec_theme_sanitize_float',
    ) );
    $wp_customize->add_control( 'mec_theme_tagline_size_desktop', array(
        'label'       => __( 'Tagline Font Size (rem)', 'mec_theme' ),
        'section'     => 'mec_theme_font_size_desktop_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 0.5, 'max' => 2, 'step' => 0.1 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_description_size_desktop', array(
        'default'           => '0.9',
        'sanitize_callback' => 'mec_theme_sanitize_float',
    ) );
    $wp_customize->add_control( 'mec_theme_description_size_desktop', array(
        'label'       => __( 'Site Description Font Size (rem)', 'mec_theme' ),
        'section'     => 'mec_theme_font_size_desktop_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 0.5, 'max' => 2, 'step' => 0.1 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_heading_size_desktop', array(
        'default'           => '2',
        'sanitize_callback' => 'mec_theme_sanitize_float',
    ) );
    $wp_customize->add_control( 'mec_theme_heading_size_desktop', array(
        'label'       => __( 'Heading (H1) Font Size (rem)', 'mec_theme' ),
        'section'     => 'mec_theme_font_size_desktop_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 1, 'max' => 4, 'step' => 0.1 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_menu_size_desktop', array(
        'default'           => '1',
        'sanitize_callback' => 'mec_theme_sanitize_float',
    ) );
    $wp_customize->add_control( 'mec_theme_menu_size_desktop', array(
        'label'       => __( 'Menu Font Size (rem)', 'mec_theme' ),
        'section'     => 'mec_theme_font_size_desktop_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 0.8, 'max' => 2, 'step' => 0.1 ),
    ) );
    
    // --- Tablet Font Sizes ---
    $wp_customize->add_section( 'mec_theme_font_size_tablet_section', array(
        'title'       => __( 'Tablet Sizes (481-768px)', 'mec_theme' ),
        'panel'       => 'mec_theme_typography_panel',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_body_font_size_tablet', array(
        'default'           => 15,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'mec_theme_body_font_size_tablet', array(
        'label'       => __( 'Body Font Size (px)', 'mec_theme' ),
        'section'     => 'mec_theme_font_size_tablet_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 12, 'max' => 22, 'step' => 1 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_site_title_size_tablet', array(
        'default'           => '1.5',
        'sanitize_callback' => 'mec_theme_sanitize_float',
    ) );
    $wp_customize->add_control( 'mec_theme_site_title_size_tablet', array(
        'label'       => __( 'Site Title Font Size (rem)', 'mec_theme' ),
        'section'     => 'mec_theme_font_size_tablet_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 1, 'max' => 3, 'step' => 0.1 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_tagline_size_tablet', array(
        'default'           => '0.9',
        'sanitize_callback' => 'mec_theme_sanitize_float',
    ) );
    $wp_customize->add_control( 'mec_theme_tagline_size_tablet', array(
        'label'       => __( 'Tagline Font Size (rem)', 'mec_theme' ),
        'section'     => 'mec_theme_font_size_tablet_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.1 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_description_size_tablet', array(
        'default'           => '0.85',
        'sanitize_callback' => 'mec_theme_sanitize_float',
    ) );
    $wp_customize->add_control( 'mec_theme_description_size_tablet', array(
        'label'       => __( 'Site Description Font Size (rem)', 'mec_theme' ),
        'section'     => 'mec_theme_font_size_tablet_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.1 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_heading_size_tablet', array(
        'default'           => '1.7',
        'sanitize_callback' => 'mec_theme_sanitize_float',
    ) );
    $wp_customize->add_control( 'mec_theme_heading_size_tablet', array(
        'label'       => __( 'Heading (H1) Font Size (rem)', 'mec_theme' ),
        'section'     => 'mec_theme_font_size_tablet_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 1, 'max' => 3, 'step' => 0.1 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_menu_size_tablet', array(
        'default'           => '0.95',
        'sanitize_callback' => 'mec_theme_sanitize_float',
    ) );
    $wp_customize->add_control( 'mec_theme_menu_size_tablet', array(
        'label'       => __( 'Menu Font Size (rem)', 'mec_theme' ),
        'section'     => 'mec_theme_font_size_tablet_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 0.8, 'max' => 1.8, 'step' => 0.1 ),
    ) );
    
    // --- Mobile Font Sizes ---
    $wp_customize->add_section( 'mec_theme_font_size_mobile_section', array(
        'title'       => __( 'Mobile Sizes (≤480px)', 'mec_theme' ),
        'panel'       => 'mec_theme_typography_panel',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_body_font_size_mobile', array(
        'default'           => 14,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'mec_theme_body_font_size_mobile', array(
        'label'       => __( 'Body Font Size (px)', 'mec_theme' ),
        'section'     => 'mec_theme_font_size_mobile_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 12, 'max' => 20, 'step' => 1 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_site_title_size_mobile', array(
        'default'           => '1.3',
        'sanitize_callback' => 'mec_theme_sanitize_float',
    ) );
    $wp_customize->add_control( 'mec_theme_site_title_size_mobile', array(
        'label'       => __( 'Site Title Font Size (rem)', 'mec_theme' ),
        'section'     => 'mec_theme_font_size_mobile_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 0.5, 'max' => 2.5, 'step' => 0.1 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_tagline_size_mobile', array(
        'default'           => '0.85',
        'sanitize_callback' => 'mec_theme_sanitize_float',
    ) );
    $wp_customize->add_control( 'mec_theme_tagline_size_mobile', array(
        'label'       => __( 'Tagline Font Size (rem)', 'mec_theme' ),
        'section'     => 'mec_theme_font_size_mobile_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 0.5, 'max' => 1.2, 'step' => 0.1 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_description_size_mobile', array(
        'default'           => '0.8',
        'sanitize_callback' => 'mec_theme_sanitize_float',
    ) );
    $wp_customize->add_control( 'mec_theme_description_size_mobile', array(
        'label'       => __( 'Site Description Font Size (rem)', 'mec_theme' ),
        'section'     => 'mec_theme_font_size_mobile_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 0.5, 'max' => 1.2, 'step' => 0.1 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_heading_size_mobile', array(
        'default'           => '1.5',
        'sanitize_callback' => 'mec_theme_sanitize_float',
    ) );
    $wp_customize->add_control( 'mec_theme_heading_size_mobile', array(
        'label'       => __( 'Heading (H1) Font Size (rem)', 'mec_theme' ),
        'section'     => 'mec_theme_font_size_mobile_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 1, 'max' => 2.5, 'step' => 0.1 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_menu_size_mobile', array(
        'default'           => '0.9',
        'sanitize_callback' => 'mec_theme_sanitize_float',
    ) );
    $wp_customize->add_control( 'mec_theme_menu_size_mobile', array(
        'label'       => __( 'Menu Font Size (rem)', 'mec_theme' ),
        'section'     => 'mec_theme_font_size_mobile_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 0.8, 'max' => 1.5, 'step' => 0.1 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_body_line_height', array(
        'default'           => '1.6',
        'sanitize_callback' => 'mec_theme_sanitize_float',
    ) );
    $wp_customize->add_control( 'mec_theme_body_line_height', array(
        'label'       => __( 'Body Line Height (all devices)', 'mec_theme' ),
        'section'     => 'mec_theme_font_size_mobile_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 1, 'max' => 2.5, 'step' => 0.1 ),
    ) );
    
    // ===== NEW SECTION: Submenu & Hamburger Settings =====
    $wp_customize->add_section( 'mec_theme_submenu_section', array(
        'title'       => __( 'Submenu & Hamburger', 'mec_theme' ),
        'panel'       => 'mec_theme_typography_panel',
        'description' => __( 'Control submenu font sizes (separate from top‑level menu) and hamburger button size on mobile/tablet.', 'mec_theme' ),
    ) );
    
    // Submenu desktop font size
    $wp_customize->add_setting( 'mec_theme_submenu_size_desktop', array(
        'default'           => '0.95',
        'sanitize_callback' => 'mec_theme_sanitize_float',
    ) );
    $wp_customize->add_control( 'mec_theme_submenu_size_desktop', array(
        'label'       => __( 'Submenu Font Size - Desktop (rem)', 'mec_theme' ),
        'section'     => 'mec_theme_submenu_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 0.7, 'max' => 1.5, 'step' => 0.05 ),
    ) );
    
    // Submenu tablet font size
    $wp_customize->add_setting( 'mec_theme_submenu_size_tablet', array(
        'default'           => '0.9',
        'sanitize_callback' => 'mec_theme_sanitize_float',
    ) );
    $wp_customize->add_control( 'mec_theme_submenu_size_tablet', array(
        'label'       => __( 'Submenu Font Size - Tablet (rem)', 'mec_theme' ),
        'section'     => 'mec_theme_submenu_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 0.7, 'max' => 1.5, 'step' => 0.05 ),
    ) );
    
    // Submenu mobile font size
    $wp_customize->add_setting( 'mec_theme_submenu_size_mobile', array(
        'default'           => '0.85',
        'sanitize_callback' => 'mec_theme_sanitize_float',
    ) );
    $wp_customize->add_control( 'mec_theme_submenu_size_mobile', array(
        'label'       => __( 'Submenu Font Size - Mobile (rem)', 'mec_theme' ),
        'section'     => 'mec_theme_submenu_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 0.7, 'max' => 1.5, 'step' => 0.05 ),
    ) );
    
    // Hamburger button width (px)
    $wp_customize->add_setting( 'mec_theme_hamburger_width', array(
        'default'           => 40,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'mec_theme_hamburger_width', array(
        'label'       => __( 'Hamburger Button Width (px) – Mobile/Tablet', 'mec_theme' ),
        'section'     => 'mec_theme_submenu_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 30, 'max' => 80, 'step' => 2 ),
    ) );
    
    // Hamburger button height (px)
    $wp_customize->add_setting( 'mec_theme_hamburger_height', array(
        'default'           => 40,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'mec_theme_hamburger_height', array(
        'label'       => __( 'Hamburger Button Height (px) – Mobile/Tablet', 'mec_theme' ),
        'section'     => 'mec_theme_submenu_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 30, 'max' => 80, 'step' => 2 ),
    ) );
    
    // Hamburger icon font size (rem)
    $wp_customize->add_setting( 'mec_theme_hamburger_font_size', array(
        'default'           => '1.2',
        'sanitize_callback' => 'mec_theme_sanitize_float',
    ) );
    $wp_customize->add_control( 'mec_theme_hamburger_font_size', array(
        'label'       => __( 'Hamburger Icon Font Size (rem) – Mobile/Tablet', 'mec_theme' ),
        'section'     => 'mec_theme_submenu_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 0.8, 'max' => 2.5, 'step' => 0.1 ),
    ) );
    
}
