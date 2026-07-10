<?php
/**
 * MEC_Theme functions and definitions
 *
 * @package MEC_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'MEC_THEME_VERSION', '1.7.35' );
define( 'MEC_THEME_DIR', get_template_directory() );
define( 'MEC_THEME_URI', get_template_directory_uri() );
define( 'MEC_THEME_ASSETS', MEC_THEME_URI . '/assets' );

/**
 * Includes
 *
 * Order matters only in that everything below must load before WordPress
 * fires its first action hook (after_setup_theme onward) -- since every
 * function in this theme is registered via add_action/add_filter rather
 * than called immediately, there is no other ordering dependency between
 * these files. Grouped here for one clear list of "what this theme loads".
 */
require_once MEC_THEME_DIR . '/inc/class-recent-posts-widget.php';
require_once MEC_THEME_DIR . '/inc/customizer-sanitizers.php';
require_once MEC_THEME_DIR . '/inc/customizer-css.php';
require_once MEC_THEME_DIR . '/inc/customizer.php';
require_once MEC_THEME_DIR . '/inc/github-updater.php';
require_once MEC_THEME_DIR . '/inc/title-settings.php';

/**
 * Theme Setup
 */
function mec_theme_setup() {
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo', array(
        'height'      => 200,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'wp-block-styles' );
    
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/editor-style.css' );
    
    // Block editor colour palette
    add_theme_support( 'editor-color-palette', array(
        array(
            'name'  => esc_html__( 'Primary', 'mec_theme' ),
            'slug'  => 'primary',
            'color' => '#0274be',
        ),
        array(
            'name'  => esc_html__( 'Secondary', 'mec_theme' ),
            'slug'  => 'secondary',
            'color' => '#3a3a3a',
        ),
        array(
            'name'  => esc_html__( 'Dark Grey', 'mec_theme' ),
            'slug'  => 'dark-grey',
            'color' => '#333333',
        ),
        array(
            'name'  => esc_html__( 'Light Grey', 'mec_theme' ),
            'slug'  => 'light-grey',
            'color' => '#666666',
        ),
        array(
            'name'  => esc_html__( 'White', 'mec_theme' ),
            'slug'  => 'white',
            'color' => '#ffffff',
        ),
    ) );
    
    // Block editor font sizes
    add_theme_support( 'editor-font-sizes', array(
        array(
            'name' => esc_html__( 'Small', 'mec_theme' ),
            'size' => 14,
            'slug' => 'small',
        ),
        array(
            'name' => esc_html__( 'Normal', 'mec_theme' ),
            'size' => 16,
            'slug' => 'normal',
        ),
        array(
            'name' => esc_html__( 'Large', 'mec_theme' ),
            'size' => 20,
            'slug' => 'large',
        ),
        array(
            'name' => esc_html__( 'Huge', 'mec_theme' ),
            'size' => 28,
            'slug' => 'huge',
        ),
    ) );
    
    add_theme_support( 'custom-line-height' );
    add_theme_support( 'custom-spacing' );
    
    add_image_size( 'mec_theme-thumbnail', 300, 200, true );
    
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'mec_theme' ),
        'footer'  => esc_html__( 'Footer Menu', 'mec_theme' ),
    ) );
    
    load_theme_textdomain( 'mec_theme', MEC_THEME_DIR . '/languages' );
}
add_action( 'after_setup_theme', 'mec_theme_setup' );

/**
 * Set content width
 */
function mec_theme_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'mec_theme_content_width', 1140 );
}
add_action( 'after_setup_theme', 'mec_theme_content_width', 0 );

/**
 * Register Widget Areas
 */
function mec_theme_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'mec_theme' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Main sidebar that appears on posts and pages.', 'mec_theme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    
    for ( $i = 1; $i <= 4; $i++ ) {
        register_sidebar( array(
            'name'          => sprintf( esc_html__( 'Footer Widget Area %d', 'mec_theme' ), $i ),
            'id'            => 'footer-' . $i,
            'description'   => sprintf( esc_html__( 'Add widgets for footer column %d.', 'mec_theme' ), $i ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );
    }
    
    register_sidebar( array(
        'name'          => esc_html__( 'Header Widget Area', 'mec_theme' ),
        'id'            => 'header-widget',
        'description'   => esc_html__( 'Add widgets to header.', 'mec_theme' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    
    // Register custom recent posts widget
    register_widget( 'MEC_Theme_Recent_Posts_Widget' );
}
add_action( 'widgets_init', 'mec_theme_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function mec_theme_scripts() {
    wp_enqueue_style( 'mec-theme-style', get_stylesheet_uri(), array(), MEC_THEME_VERSION );
    
    // Add cached customizer CSS as inline style
    $customizer_css = mec_theme_get_cached_customizer_css();
    if ( ! empty( $customizer_css ) ) {
        wp_add_inline_style( 'mec-theme-style', $customizer_css );
    }
    
    wp_enqueue_script( 'mec-theme-navigation', MEC_THEME_URI . '/assets/js/navigation.js', array(), MEC_THEME_VERSION, true );
    
    wp_localize_script( 'mec-theme-navigation', 'mecThemeVars', array(
        'menuText' => esc_html__( 'Menu', 'mec_theme' ),
        'closeText' => esc_html__( 'Close', 'mec_theme' ),
    ) );
    
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'mec_theme_scripts' );

/**
 * Enqueue Customizer preview script
 */
function mec_theme_customize_preview_js() {
    if ( is_customize_preview() ) {
        wp_enqueue_script( 'mec-theme-customizer-preview', MEC_THEME_URI . '/assets/js/customizer-preview.js', array( 'jquery', 'customize-preview' ), MEC_THEME_VERSION, true );
    }
}
add_action( 'customize_preview_init', 'mec_theme_customize_preview_js' );

/**
 * Add custom classes to body
 */
function mec_theme_body_classes( $classes ) {
    if ( is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'has-sidebar';
    } else {
        $classes[] = 'no-sidebar';
    }
    
    $sidebar_position = get_theme_mod( 'mec_theme_sidebar_position', 'right' );
    $sidebar_position = sanitize_html_class( $sidebar_position, 'right' );
    $classes[] = 'sidebar-' . $sidebar_position;
    
    if ( get_theme_mod( 'mec_theme_sticky_header', false ) ) {
        $classes[] = 'has-sticky-header';
    }
    
    return $classes;
}
add_filter( 'body_class', 'mec_theme_body_classes' );

/**
 * Custom excerpt length
 */
function mec_theme_excerpt_length( $length ) {
    return get_theme_mod( 'mec_theme_excerpt_length', 30 );
}
add_filter( 'excerpt_length', 'mec_theme_excerpt_length' );

/**
 * Custom excerpt more
 */
function mec_theme_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'mec_theme_excerpt_more' );

/**
 * Add menu descriptions
 */
function mec_theme_add_menu_descriptions( $item_output, $item, $depth, $args ) {
    if ( ! empty( $item->description ) && in_array( $args->theme_location, array( 'primary', 'footer' ) ) ) {
        $item_output = str_replace( '</a>', '<span class="menu-description">' . esc_html( $item->description ) . '</span></a>', $item_output );
    }
    return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'mec_theme_add_menu_descriptions', 10, 4 );

/**
 * Author bio template
 */
function mec_theme_author_bio() {
    if ( ! is_single() ) {
        return;
    }
    if ( get_theme_mod( 'mec_theme_show_author_bio', true ) ) {
        get_template_part( 'template-parts/author-bio' );
    }
}

/**
 * Related posts template
 */
function mec_theme_related_posts() {
    if ( ! is_single() ) {
        return;
    }
    if ( get_theme_mod( 'mec_theme_show_related_posts', true ) ) {
        get_template_part( 'template-parts/related-posts' );
    }
}

/**
 * Security: Remove unnecessary head items
 */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );

/**
 * Check WordPress version
 */
function mec_theme_version_check() {
    if ( version_compare( $GLOBALS['wp_version'], '5.0', '<' ) ) {
        add_action( 'admin_notices', 'mec_theme_upgrade_notice' );
    }
}
add_action( 'after_switch_theme', 'mec_theme_version_check' );

/**
 * Admin notice for older WordPress versions
 */
function mec_theme_upgrade_notice() {
    if ( ! current_user_can( 'switch_themes' ) ) {
        return;
    }
    ?>
    <div class="notice notice-warning is-dismissible">
        <p><?php esc_html_e( 'Your WordPress version is outdated. MEC_Theme requires WordPress 5.0 or newer for full functionality.', 'mec_theme' ); ?></p>
    </div>
    <?php
}
