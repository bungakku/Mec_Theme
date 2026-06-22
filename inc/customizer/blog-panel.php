<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Customizer: Blog Settings panel
 *
 * Blog Layout, Post Elements, and Single Post sections.
 * Registered via mec_theme_customize_register() in inc/customizer.php.
 *
 * Extracted from inc/customizer.php during the 1.7.4 file-organization
 * pass. No behavior changed -- this is the same code that used to live
 * inline inside mec_theme_customize_register(), now in its own function.
 *
 * @package MEC_Theme
 * @version 1.7.4
 */
function mec_theme_register_blog_panel( $wp_customize ) {
    
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
