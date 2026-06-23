<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Customizer: Layout Settings panel
 *
 * Sidebar, Container, Header, Menu, and Footer sections.
 * Registered via mec_theme_customize_register() in inc/customizer.php.
 *
 * Extracted from inc/customizer.php during the 1.7.8 file-organization
 * pass. No behavior changed -- this is the same code that used to live
 * inline inside mec_theme_customize_register(), now in its own function.
 *
 * @package MEC_Theme
 * @version 1.7.8
 */
function mec_theme_register_layout_panel( $wp_customize ) {
    
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
    
}
