<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Customizer Settings
 *
 * @package MEC_Theme
 * @version 1.7.0
 */

function mec_theme_customize_register( $wp_customize ) {
    
    // === Layout Settings Panel ===
    $wp_customize->add_panel( 'mec_theme_layout_panel', array(
        'title'       => __( 'Layout Settings', 'mec_theme' ),
        'priority'    => 30,
    ) );
    
    // --- Sidebar Section ---
    $wp_customize->add_section( 'mec_theme_sidebar_section', array(
        'title'       => __( 'Sidebar', 'mec_theme' ),
        'panel'       => 'mec_theme_layout_panel',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_sidebar_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'mec_theme_sanitize_sidebar_position',
    ) );
    $wp_customize->add_control( 'mec_theme_sidebar_position', array(
        'label'       => __( 'Sidebar Position', 'mec_theme' ),
        'section'     => 'mec_theme_sidebar_section',
        'type'        => 'radio',
        'choices'     => array(
            'left'  => __( 'Left Sidebar', 'mec_theme' ),
            'right' => __( 'Right Sidebar', 'mec_theme' ),
        ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_content_width', array(
        'default'           => 70,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'mec_theme_content_width', array(
        'label'       => __( 'Main Content Width (%)', 'mec_theme' ),
        'description' => __( 'Recommended: 70% (with sidebar width 25% leaves 5% for gap).', 'mec_theme' ),
        'section'     => 'mec_theme_sidebar_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 50, 'max' => 80, 'step' => 1 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_sidebar_width', array(
        'default'           => 25,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'mec_theme_sidebar_width', array(
        'label'       => __( 'Sidebar Width (%)', 'mec_theme' ),
        'description' => __( 'Recommended: 25% (together with content width should not exceed 100%).', 'mec_theme' ),
        'section'     => 'mec_theme_sidebar_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 20, 'max' => 40, 'step' => 1 ),
    ) );
    
    // NEW: Sidebar Background Color
    $wp_customize->add_setting( 'mec_theme_sidebar_bg', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_sidebar_bg', array(
        'label'    => __( 'Sidebar Background Color', 'mec_theme' ),
        'section'  => 'mec_theme_sidebar_section',
    ) ) );
    
    // --- Container Section ---
    $wp_customize->add_section( 'mec_theme_container_section', array(
        'title'       => __( 'Container', 'mec_theme' ),
        'panel'       => 'mec_theme_layout_panel',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_container_width', array(
        'default'           => 1200,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'mec_theme_container_width', array(
        'label'       => __( 'Container Width (px)', 'mec_theme' ),
        'section'     => 'mec_theme_container_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 800, 'max' => 1600, 'step' => 10 ),
    ) );
    
    // --- Header Section ---
    $wp_customize->add_section( 'mec_theme_header_section', array(
        'title'       => __( 'Header', 'mec_theme' ),
        'panel'       => 'mec_theme_layout_panel',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_logo_position_desktop', array(
        'default'           => get_theme_mod( 'mec_theme_logo_position', 'left' ),
        'sanitize_callback' => 'mec_theme_sanitize_logo_position',
    ) );
    $wp_customize->add_control( 'mec_theme_logo_position_desktop', array(
        'label'       => __( 'Logo Position (Desktop)', 'mec_theme' ),
        'section'     => 'mec_theme_header_section',
        'type'        => 'select',
        'choices'     => array(
            'left'   => __( 'Left of Site Title', 'mec_theme' ),
            'right'  => __( 'Right of Site Title', 'mec_theme' ),
            'top'    => __( 'Above Site Title', 'mec_theme' ),
            'bottom' => __( 'Below Site Title', 'mec_theme' ),
        ),
    ) );

    $wp_customize->add_setting( 'mec_theme_logo_position_tablet', array(
        'default'           => get_theme_mod( 'mec_theme_logo_position', 'left' ),
        'sanitize_callback' => 'mec_theme_sanitize_logo_position',
    ) );
    $wp_customize->add_control( 'mec_theme_logo_position_tablet', array(
        'label'       => __( 'Logo Position (Tablet)', 'mec_theme' ),
        'section'     => 'mec_theme_header_section',
        'type'        => 'select',
        'choices'     => array(
            'left'   => __( 'Left of Site Title', 'mec_theme' ),
            'right'  => __( 'Right of Site Title', 'mec_theme' ),
            'top'    => __( 'Above Site Title', 'mec_theme' ),
            'bottom' => __( 'Below Site Title', 'mec_theme' ),
        ),
    ) );

    $wp_customize->add_setting( 'mec_theme_logo_position_mobile', array(
        'default'           => get_theme_mod( 'mec_theme_logo_position', 'left' ),
        'sanitize_callback' => 'mec_theme_sanitize_logo_position',
    ) );
    $wp_customize->add_control( 'mec_theme_logo_position_mobile', array(
        'label'       => __( 'Logo Position (Mobile)', 'mec_theme' ),
        'section'     => 'mec_theme_header_section',
        'type'        => 'select',
        'choices'     => array(
            'left'   => __( 'Left of Site Title', 'mec_theme' ),
            'right'  => __( 'Right of Site Title', 'mec_theme' ),
            'top'    => __( 'Above Site Title', 'mec_theme' ),
            'bottom' => __( 'Below Site Title', 'mec_theme' ),
        ),
    ) );

    $wp_customize->add_setting( 'mec_theme_title_align_desktop', array(
        'default'           => 'left',
        'sanitize_callback' => 'mec_theme_sanitize_text_align',
    ) );
    $wp_customize->add_control( 'mec_theme_title_align_desktop', array(
        'label'       => __( 'Title/Description Alignment (Desktop)', 'mec_theme' ),
        'section'     => 'mec_theme_header_section',
        'type'        => 'select',
        'choices'     => array(
            'left'   => __( 'Left', 'mec_theme' ),
            'center' => __( 'Center', 'mec_theme' ),
            'right'  => __( 'Right', 'mec_theme' ),
        ),
    ) );

    $wp_customize->add_setting( 'mec_theme_title_align_tablet', array(
        'default'           => 'left',
        'sanitize_callback' => 'mec_theme_sanitize_text_align',
    ) );
    $wp_customize->add_control( 'mec_theme_title_align_tablet', array(
        'label'       => __( 'Title/Description Alignment (Tablet)', 'mec_theme' ),
        'section'     => 'mec_theme_header_section',
        'type'        => 'select',
        'choices'     => array(
            'left'   => __( 'Left', 'mec_theme' ),
            'center' => __( 'Center', 'mec_theme' ),
            'right'  => __( 'Right', 'mec_theme' ),
        ),
    ) );

    $wp_customize->add_setting( 'mec_theme_title_align_mobile', array(
        'default'           => 'left',
        'sanitize_callback' => 'mec_theme_sanitize_text_align',
    ) );
    $wp_customize->add_control( 'mec_theme_title_align_mobile', array(
        'label'       => __( 'Title/Description Alignment (Mobile)', 'mec_theme' ),
        'section'     => 'mec_theme_header_section',
        'type'        => 'select',
        'choices'     => array(
            'left'   => __( 'Left', 'mec_theme' ),
            'center' => __( 'Center', 'mec_theme' ),
            'right'  => __( 'Right', 'mec_theme' ),
        ),
    ) );

    // NEW: Tagline Alignment (separate from title/description)
    $wp_customize->add_setting( 'mec_theme_tagline_align', array(
        'default'           => 'center',
        'sanitize_callback' => 'mec_theme_sanitize_text_align',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'mec_theme_tagline_align', array(
        'label'       => __( 'Tagline Alignment', 'mec_theme' ),
        'section'     => 'mec_theme_header_section',
        'type'        => 'select',
        'choices'     => array(
            'left'   => __( 'Left', 'mec_theme' ),
            'center' => __( 'Center', 'mec_theme' ),
            'right'  => __( 'Right', 'mec_theme' ),
        ),
    ) );

    $wp_customize->add_setting( 'mec_theme_hide_description_tablet', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'mec_theme_hide_description_tablet', array(
        'label'       => __( 'Hide Site Description on Tablet', 'mec_theme' ),
        'section'     => 'mec_theme_header_section',
        'type'        => 'checkbox',
    ) );

    $wp_customize->add_setting( 'mec_theme_hide_description_mobile', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'mec_theme_hide_description_mobile', array(
        'label'       => __( 'Hide Site Description on Mobile', 'mec_theme' ),
        'section'     => 'mec_theme_header_section',
        'type'        => 'checkbox',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_logo_max_width_desktop', array(
        'default'           => 200,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'mec_theme_logo_max_width_desktop', array(
        'label'       => __( 'Logo Max Width - Desktop (>768px)', 'mec_theme' ),
        'section'     => 'mec_theme_header_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 50, 'max' => 400, 'step' => 5 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_logo_max_width_tablet', array(
        'default'           => 150,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'mec_theme_logo_max_width_tablet', array(
        'label'       => __( 'Logo Max Width - Tablet (481-768px)', 'mec_theme' ),
        'section'     => 'mec_theme_header_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 50, 'max' => 300, 'step' => 5 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_logo_max_width_mobile', array(
        'default'           => 120,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'mec_theme_logo_max_width_mobile', array(
        'label'       => __( 'Logo Max Width - Mobile (≤480px)', 'mec_theme' ),
        'section'     => 'mec_theme_header_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 50, 'max' => 200, 'step' => 5 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_sticky_header', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'mec_theme_sticky_header', array(
        'label'       => __( 'Enable Sticky Header', 'mec_theme' ),
        'section'     => 'mec_theme_header_section',
        'type'        => 'checkbox',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_header_padding', array(
        'default'           => 15,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'mec_theme_header_padding', array(
        'label'       => __( 'Header Padding (px)', 'mec_theme' ),
        'section'     => 'mec_theme_header_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 0, 'max' => 50, 'step' => 1 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_show_description', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'mec_theme_show_description', array(
        'label'       => __( 'Show Site Description (Global)', 'mec_theme' ),
        'section'     => 'mec_theme_header_section',
        'type'        => 'checkbox',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_custom_description', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'mec_theme_custom_description', array(
        'label'       => __( 'Custom Site Description', 'mec_theme' ),
        'description' => __( 'You can use HTML tags like &lt;br&gt; for line breaks.', 'mec_theme' ),
        'section'     => 'mec_theme_header_section',
        'type'        => 'textarea',
    ) );
    
    // --- Menu Section ---
    $wp_customize->add_section( 'mec_theme_menu_section', array(
        'title'       => __( 'Menu Settings', 'mec_theme' ),
        'panel'       => 'mec_theme_layout_panel',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_menu_padding', array(
        'default'           => 10,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'mec_theme_menu_padding', array(
        'label'       => __( 'Menu Item Padding (px)', 'mec_theme' ),
        'section'     => 'mec_theme_menu_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 0, 'max' => 30, 'step' => 1 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_menu_spacing', array(
        'default'           => 20,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'mec_theme_menu_spacing', array(
        'label'       => __( 'Menu Item Spacing (px)', 'mec_theme' ),
        'section'     => 'mec_theme_menu_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 0, 'max' => 50, 'step' => 1 ),
    ) );
    
    // Main Menu Hover Color
    $wp_customize->add_setting( 'mec_theme_menu_hover_color', array(
        'default'           => '#0274be',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_menu_hover_color', array(
        'label'    => __( 'Main Menu Hover Color', 'mec_theme' ),
        'section'  => 'mec_theme_menu_section',
        'settings' => 'mec_theme_menu_hover_color',
    ) ) );
    
    $wp_customize->add_setting( 'mec_theme_show_menu_descriptions', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'mec_theme_show_menu_descriptions', array(
        'label'       => __( 'Show Menu Descriptions', 'mec_theme' ),
        'section'     => 'mec_theme_menu_section',
        'type'        => 'checkbox',
    ) );
    
    // --- Footer Section ---
    $wp_customize->add_section( 'mec_theme_footer_section', array(
        'title'       => __( 'Footer Settings', 'mec_theme' ),
        'panel'       => 'mec_theme_layout_panel',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_footer_layout', array(
        'default'           => '4',
        'sanitize_callback' => 'mec_theme_sanitize_footer_columns',
    ) );
    $wp_customize->add_control( 'mec_theme_footer_layout', array(
        'label'       => __( 'Footer Widget Columns', 'mec_theme' ),
        'section'     => 'mec_theme_footer_section',
        'type'        => 'select',
        'choices'     => array(
            '1' => __( '1 Column', 'mec_theme' ),
            '2' => __( '2 Columns', 'mec_theme' ),
            '3' => __( '3 Columns', 'mec_theme' ),
            '4' => __( '4 Columns', 'mec_theme' ),
        ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_footer_direction', array(
        'default'           => 'horizontal',
        'sanitize_callback' => 'mec_theme_sanitize_footer_direction',
    ) );
    $wp_customize->add_control( 'mec_theme_footer_direction', array(
        'label'       => __( 'Footer Widgets Layout', 'mec_theme' ),
        'section'     => 'mec_theme_footer_section',
        'type'        => 'radio',
        'choices'     => array(
            'horizontal' => __( 'Horizontal (Row)', 'mec_theme' ),
            'vertical'   => __( 'Vertical (Stack)', 'mec_theme' ),
        ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_footer_bg', array(
        'default'           => '#f8f9fa',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_footer_bg', array(
        'label'    => __( 'Footer Background', 'mec_theme' ),
        'section'  => 'mec_theme_footer_section',
    ) ) );
    
    $wp_customize->add_setting( 'mec_theme_footer_padding', array(
        'default'           => 40,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'mec_theme_footer_padding', array(
        'label'       => __( 'Footer Padding (px)', 'mec_theme' ),
        'section'     => 'mec_theme_footer_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 0, 'max' => 100, 'step' => 5 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_copyright_text', array(
        'default'           => '&copy; ' . date_i18n('Y') . ' ' . get_bloginfo('name') . '. All rights reserved.',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'mec_theme_copyright_text', array(
        'label'       => __( 'Copyright Text', 'mec_theme' ),
        'section'     => 'mec_theme_footer_section',
        'type'        => 'textarea',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_copyright_color', array(
        'default'           => '#666666',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_copyright_color', array(
        'label'    => __( 'Copyright Text Color', 'mec_theme' ),
        'section'  => 'mec_theme_footer_section',
    ) ) );
    
    $wp_customize->add_setting( 'mec_theme_show_footer_menu', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'mec_theme_show_footer_menu', array(
        'label'       => __( 'Show Footer Menu', 'mec_theme' ),
        'section'     => 'mec_theme_footer_section',
        'type'        => 'checkbox',
    ) );
    
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

    // --- Mobile Menu Colors Section ---
    $wp_customize->add_section( 'mec_theme_mobile_menu_colors_section', array(
        'title'       => __( 'Mobile Menu Colors', 'mec_theme' ),
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
    
    // === Blog Settings Panel ===
    $wp_customize->add_panel( 'mec_theme_blog_panel', array(
        'title'       => __( 'Blog Settings', 'mec_theme' ),
        'priority'    => 60,
    ) );
    
    // --- Blog Layout Section ---
    $wp_customize->add_section( 'mec_theme_blog_layout_section', array(
        'title'       => __( 'Blog Layout', 'mec_theme' ),
        'panel'       => 'mec_theme_blog_panel',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_blog_layout', array(
        'default'           => 'classic',
        'sanitize_callback' => 'mec_theme_sanitize_blog_layout',
    ) );
    $wp_customize->add_control( 'mec_theme_blog_layout', array(
        'label'       => __( 'Blog Layout Style', 'mec_theme' ),
        'section'     => 'mec_theme_blog_layout_section',
        'type'        => 'radio',
        'choices'     => array(
            'classic' => __( 'Classic (Full Width)', 'mec_theme' ),
            'grid'    => __( 'Grid Layout', 'mec_theme' ),
            'list'    => __( 'List Layout', 'mec_theme' ),
        ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_grid_columns', array(
        'default'           => '2',
        'sanitize_callback' => 'mec_theme_sanitize_grid_columns',
    ) );
    $wp_customize->add_control( 'mec_theme_grid_columns', array(
        'label'       => __( 'Grid Columns', 'mec_theme' ),
        'section'     => 'mec_theme_blog_layout_section',
        'type'        => 'select',
        'choices'     => array(
            '2' => __( '2 Columns', 'mec_theme' ),
            '3' => __( '3 Columns', 'mec_theme' ),
            '4' => __( '4 Columns', 'mec_theme' ),
        ),
    ) );
    
    // --- Post Elements Section ---
    $wp_customize->add_section( 'mec_theme_post_elements_section', array(
        'title'       => __( 'Post Elements', 'mec_theme' ),
        'panel'       => 'mec_theme_blog_panel',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_show_featured_image', array(
        'default'           => 'show',
        'sanitize_callback' => 'mec_theme_sanitize_show_hide',
    ) );
    $wp_customize->add_control( 'mec_theme_show_featured_image', array(
        'label'       => __( 'Featured Image', 'mec_theme' ),
        'section'     => 'mec_theme_post_elements_section',
        'type'        => 'radio',
        'choices'     => array(
            'show' => __( 'Show', 'mec_theme' ),
            'hide' => __( 'Hide', 'mec_theme' ),
        ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_featured_image_size', array(
        'default'           => 'large',
        'sanitize_callback' => 'mec_theme_sanitize_image_size',
    ) );
    $wp_customize->add_control( 'mec_theme_featured_image_size', array(
        'label'       => __( 'Featured Image Size', 'mec_theme' ),
        'section'     => 'mec_theme_post_elements_section',
        'type'        => 'select',
        'choices'     => array(
            'thumbnail' => __( 'Thumbnail', 'mec_theme' ),
            'medium'    => __( 'Medium', 'mec_theme' ),
            'large'     => __( 'Large', 'mec_theme' ),
            'full'      => __( 'Full Size', 'mec_theme' ),
        ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_show_post_meta', array(
        'default'           => 'show',
        'sanitize_callback' => 'mec_theme_sanitize_post_meta',
    ) );
    $wp_customize->add_control( 'mec_theme_show_post_meta', array(
        'label'       => __( 'Post Meta', 'mec_theme' ),
        'section'     => 'mec_theme_post_elements_section',
        'type'        => 'radio',
        'choices'     => array(
            'show'   => __( 'Show All Meta', 'mec_theme' ),
            'hide'   => __( 'Hide All Meta', 'mec_theme' ),
            'custom' => __( 'Custom Selection', 'mec_theme' ),
        ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_show_post_date', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'mec_theme_show_post_date', array(
        'label'       => __( 'Show Post Date', 'mec_theme' ),
        'section'     => 'mec_theme_post_elements_section',
        'type'        => 'checkbox',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_show_post_author', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'mec_theme_show_post_author', array(
        'label'       => __( 'Show Post Author', 'mec_theme' ),
        'section'     => 'mec_theme_post_elements_section',
        'type'        => 'checkbox',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_show_post_comments', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'mec_theme_show_post_comments', array(
        'label'       => __( 'Show Comment Count', 'mec_theme' ),
        'section'     => 'mec_theme_post_elements_section',
        'type'        => 'checkbox',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_show_post_categories', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'mec_theme_show_post_categories', array(
        'label'       => __( 'Show Post Categories', 'mec_theme' ),
        'section'     => 'mec_theme_post_elements_section',
        'type'        => 'checkbox',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_content_display', array(
        'default'           => 'excerpt',
        'sanitize_callback' => 'mec_theme_sanitize_content_display',
    ) );
    $wp_customize->add_control( 'mec_theme_content_display', array(
        'label'       => __( 'Content Display', 'mec_theme' ),
        'section'     => 'mec_theme_post_elements_section',
        'type'        => 'radio',
        'choices'     => array(
            'excerpt' => __( 'Excerpt', 'mec_theme' ),
            'full'    => __( 'Full Content', 'mec_theme' ),
            'none'    => __( 'No Content (Title Only)', 'mec_theme' ),
        ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_excerpt_length', array(
        'default'           => 30,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'mec_theme_excerpt_length', array(
        'label'       => __( 'Excerpt Length (words)', 'mec_theme' ),
        'section'     => 'mec_theme_post_elements_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 10, 'max' => 100, 'step' => 5 ),
    ) );
    
    $wp_customize->add_setting( 'mec_theme_show_read_more', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'mec_theme_show_read_more', array(
        'label'       => __( 'Show Read More Button', 'mec_theme' ),
        'section'     => 'mec_theme_post_elements_section',
        'type'        => 'checkbox',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_read_more_text', array(
        'default'           => 'Read More',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'mec_theme_read_more_text', array(
        'label'       => __( 'Read More Button Text', 'mec_theme' ),
        'section'     => 'mec_theme_post_elements_section',
        'type'        => 'text',
    ) );
    
    // --- Single Post Section ---
    $wp_customize->add_section( 'mec_theme_single_post_section', array(
        'title'       => __( 'Single Post', 'mec_theme' ),
        'panel'       => 'mec_theme_blog_panel',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_show_author_bio', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'mec_theme_show_author_bio', array(
        'label'       => __( 'Show Author Bio on Single Posts', 'mec_theme' ),
        'section'     => 'mec_theme_single_post_section',
        'type'        => 'checkbox',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_show_related_posts', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ) );
    $wp_customize->add_control( 'mec_theme_show_related_posts', array(
        'label'       => __( 'Show Related Posts', 'mec_theme' ),
        'section'     => 'mec_theme_single_post_section',
        'type'        => 'checkbox',
    ) );
    
    $wp_customize->add_setting( 'mec_theme_related_count', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'mec_theme_related_count', array(
        'label'       => __( 'Number of Related Posts', 'mec_theme' ),
        'section'     => 'mec_theme_single_post_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 1, 'max' => 6, 'step' => 1 ),
    ) );
}
add_action( 'customize_register', 'mec_theme_customize_register' );

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
    $content_width = get_theme_mod( 'mec_theme_content_width', 70 );
    $sidebar_width = get_theme_mod( 'mec_theme_sidebar_width', 25 );

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