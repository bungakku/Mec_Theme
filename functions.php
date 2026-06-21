<?php
/**
 * MEC_Theme functions and definitions
 *
 * @package MEC_Theme
 * @version 1.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'MEC_THEME_VERSION', '1.7.0' );
define( 'MEC_THEME_DIR', get_template_directory() );
define( 'MEC_THEME_URI', get_template_directory_uri() );
define( 'MEC_THEME_ASSETS', MEC_THEME_URI . '/assets' );

/**
 * Helper: Get theme mod colour with fallback.
 */
function mec_theme_get_color_var( $mod, $default ) {
    $color = get_theme_mod( $mod, $default );
    $sanitized = sanitize_hex_color( $color );
    return $sanitized ?: $default;
}

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
        'social'  => esc_html__( 'Social Menu', 'mec_theme' ),
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
 * Custom Recent Posts Widget with Excerpt and Read More
 */
class MEC_Theme_Recent_Posts_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'mec_theme_recent_posts',
            esc_html__( 'MEC Recent Posts (with excerpt)', 'mec_theme' ),
            array(
                'description' => esc_html__( 'Display recent posts with thumbnail, excerpt and read more link.', 'mec_theme' ),
                'classname'   => 'widget_mec_recent_posts',
            )
        );
    }
    
    public function widget( $args, $instance ) {
        $title = ! empty( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
        $number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_thumbnail = isset( $instance['show_thumbnail'] ) ? (bool) $instance['show_thumbnail'] : true;
        $show_excerpt = isset( $instance['show_excerpt'] ) ? (bool) $instance['show_excerpt'] : true;
        $show_readmore = isset( $instance['show_readmore'] ) ? (bool) $instance['show_readmore'] : true;
        $excerpt_length = ! empty( $instance['excerpt_length'] ) ? absint( $instance['excerpt_length'] ) : 15;
        
        $query_args = array(
            'posts_per_page'      => $number,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
        );
        
        $recent_posts = new WP_Query( $query_args );
        
        echo $args['before_widget'];
        
        if ( $title ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }
        
        if ( $recent_posts->have_posts() ) : ?>
            <ul class="mec-recent-posts-list">
                <?php while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>
                    <li class="mec-recent-post-item">
                        <?php if ( $show_thumbnail && has_post_thumbnail() ) : ?>
                            <div class="recent-post-thumb">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'thumbnail' ); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="recent-post-content">
                            <h4 class="recent-post-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                            <?php if ( $show_excerpt ) : ?>
                                <div class="recent-post-excerpt">
                                    <?php echo wp_trim_words( get_the_excerpt(), $excerpt_length, '...' ); ?>
                                </div>
                            <?php endif; ?>
                            <?php if ( $show_readmore ) : ?>
                                <a href="<?php the_permalink(); ?>" class="read-more-link">
                                    <?php esc_html_e( 'Read More', 'mec_theme' ); ?> &rarr;
                                </a>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <p><?php esc_html_e( 'No posts found.', 'mec_theme' ); ?></p>
        <?php endif;
        
        echo $args['after_widget'];
    }
    
    public function form( $instance ) {
        $title = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Recent Posts', 'mec_theme' );
        $number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_thumbnail = isset( $instance['show_thumbnail'] ) ? (bool) $instance['show_thumbnail'] : true;
        $show_excerpt = isset( $instance['show_excerpt'] ) ? (bool) $instance['show_excerpt'] : true;
        $show_readmore = isset( $instance['show_readmore'] ) ? (bool) $instance['show_readmore'] : true;
        $excerpt_length = isset( $instance['excerpt_length'] ) ? absint( $instance['excerpt_length'] ) : 15;
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'mec_theme' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts to show:', 'mec_theme' ); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" max="20" value="<?php echo esc_attr( $number ); ?>">
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked( $show_thumbnail ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_thumbnail' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_thumbnail' ) ); ?>">
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_thumbnail' ) ); ?>"><?php esc_html_e( 'Show featured image', 'mec_theme' ); ?></label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked( $show_excerpt ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_excerpt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_excerpt' ) ); ?>">
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_excerpt' ) ); ?>"><?php esc_html_e( 'Show excerpt', 'mec_theme' ); ?></label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked( $show_readmore ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_readmore' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_readmore' ) ); ?>">
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_readmore' ) ); ?>"><?php esc_html_e( 'Show "Read More" link', 'mec_theme' ); ?></label>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'excerpt_length' ) ); ?>"><?php esc_html_e( 'Excerpt length (words):', 'mec_theme' ); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'excerpt_length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt_length' ) ); ?>" type="number" step="1" min="5" max="100" value="<?php echo esc_attr( $excerpt_length ); ?>">
        </p>
        <?php
    }
    
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['number'] = absint( $new_instance['number'] );
        $instance['show_thumbnail'] = ! empty( $new_instance['show_thumbnail'] );
        $instance['show_excerpt'] = ! empty( $new_instance['show_excerpt'] );
        $instance['show_readmore'] = ! empty( $new_instance['show_readmore'] );
        $instance['excerpt_length'] = absint( $new_instance['excerpt_length'] );
        return $instance;
    }
}

/**
 * Generate CSS variables for :root from Customizer settings
 * with fallback for invalid hex colours.
 */
function mec_theme_get_root_variables_css() {
    $css = ':root {';
    
    // Colours – existing ones
    $primary = mec_theme_get_color_var( 'mec_theme_link_color', '#0274be' );
    $css .= '--mec-primary-color: ' . $primary . ';';
    
    $secondary = mec_theme_get_color_var( 'mec_theme_menu_color', '#3a3a3a' );
    $css .= '--mec-secondary-color: ' . $secondary . ';';
    
    $text = mec_theme_get_color_var( 'mec_theme_text_color', '#333333' );
    $css .= '--mec-text-color: ' . $text . ';';
    
    $link_hover = mec_theme_get_color_var( 'mec_theme_link_hover_color', '#3a3a3a' );
    $css .= '--mec-link-hover-color: ' . $link_hover . ';';
    
    $heading = mec_theme_get_color_var( 'mec_theme_heading_color', '#333333' );
    $css .= '--mec-heading-color: ' . $heading . ';';
    
    $header_bg = mec_theme_get_color_var( 'mec_theme_header_bg', '#ffffff' );
    $css .= '--mec-header-bg: ' . $header_bg . ';';
    
    $footer_bg = mec_theme_get_color_var( 'mec_theme_footer_bg', '#f8f9fa' );
    $css .= '--mec-footer-bg: ' . $footer_bg . ';';
    
    $copyright_color = mec_theme_get_color_var( 'mec_theme_copyright_color', '#666666' );
    $css .= '--mec-copyright-color: ' . $copyright_color . ';';
    
    $site_title_color = mec_theme_get_color_var( 'mec_theme_site_title_color', '#333333' );
    $css .= '--mec-site-title-color: ' . $site_title_color . ';';
    
    $site_desc_color = mec_theme_get_color_var( 'mec_theme_site_description_color', '#666666' );
    $css .= '--mec-site-description-color: ' . $site_desc_color . ';';
    
    $tagline_color = mec_theme_get_color_var( 'mec_theme_tagline_color', '#666666' );
    $css .= '--mec-tagline-color: ' . $tagline_color . ';';
    
    // Tagline alignment
    $tagline_align = get_theme_mod( 'mec_theme_tagline_align', 'center' );
    $css .= '--mec-tagline-align: ' . esc_attr( $tagline_align ) . ';';
    
    $menu_color = mec_theme_get_color_var( 'mec_theme_menu_color', '#3a3a3a' );
    $css .= '--mec-menu-color: ' . $menu_color . ';';
    
    $menu_hover = mec_theme_get_color_var( 'mec_theme_menu_hover_color', '#0274be' );
    $css .= '--mec-menu-hover-color: ' . $menu_hover . ';';
    
    $dropdown_bg = mec_theme_get_color_var( 'mec_theme_dropdown_bg', '#ffffff' );
    $css .= '--mec-dropdown-bg: ' . $dropdown_bg . ';';
    
    $dropdown_text = mec_theme_get_color_var( 'mec_theme_dropdown_text', '#3a3a3a' );
    $css .= '--mec-dropdown-text: ' . $dropdown_text . ';';
    
    $dropdown_hover_bg = mec_theme_get_color_var( 'mec_theme_dropdown_hover_bg', '#f8f9fa' );
    $css .= '--mec-dropdown-hover-bg: ' . $dropdown_hover_bg . ';';
    
    $dropdown_hover_text = mec_theme_get_color_var( 'mec_theme_dropdown_hover_text', '#0274be' );
    $css .= '--mec-dropdown-hover-text: ' . $dropdown_hover_text . ';';
    
    // Sidebar background
    $sidebar_bg = mec_theme_get_color_var( 'mec_theme_sidebar_bg', '#ffffff' );
    $css .= '--mec-sidebar-bg: ' . $sidebar_bg . ';';
    
    // Layout
    $container_width = get_theme_mod( 'mec_theme_container_width', 1200 );
    $css .= '--mec-container-width: ' . absint( $container_width ) . 'px;';
    
    $header_padding = get_theme_mod( 'mec_theme_header_padding', 15 );
    $css .= '--mec-header-padding: ' . absint( $header_padding ) . 'px;';
    
    // Social icons
    $social_size = get_theme_mod( 'mec_theme_social_icon_size', 36 );
    $css .= '--mec-social-icon-size: ' . absint( $social_size ) . 'px;';
    
    $social_font = get_theme_mod( 'mec_theme_social_icon_font_size', 18 );
    $css .= '--mec-social-icon-font-size: ' . absint( $social_font ) . 'px;';
    
    $social_bg = mec_theme_get_color_var( 'mec_theme_social_icon_bg', '#e0e0e0' );
    $css .= '--mec-social-icon-bg: ' . $social_bg . ';';
    
    $social_color = mec_theme_get_color_var( 'mec_theme_social_icon_color', '#333333' );
    $css .= '--mec-social-icon-color: ' . $social_color . ';';
    
    $social_hover_bg = mec_theme_get_color_var( 'mec_theme_social_icon_hover_bg', '#cccccc' );
    $css .= '--mec-social-icon-hover-bg: ' . $social_hover_bg . ';';
    
    $social_hover_color = mec_theme_get_color_var( 'mec_theme_social_icon_hover_color', '#ffffff' );
    $css .= '--mec-social-icon-hover-color: ' . $social_hover_color . ';';
    
    // Mobile close colour
    $close_color = mec_theme_get_color_var( 'mec_theme_mobile_close_color', '#333333' );
    $css .= '--mec-mobile-close-color: ' . $close_color . ';';
    
    // Body line height
    $line_height = get_theme_mod( 'mec_theme_body_line_height', '1.6' );
    $css .= '--mec-body-line-height: ' . floatval( $line_height ) . ';';
    
    $css .= '}';
    return $css;
}

/**
 * Generate static CSS rules that use CSS variables
 */
function mec_theme_get_static_rules_css() {
    $css = '';
    
    // Font families – safe because values come from dropdown
    $body_font = get_theme_mod( 'mec_theme_body_font_family', 'default' );
    $formatted_body_font = mec_theme_format_font_family( $body_font );
    if ( $formatted_body_font ) {
        $css .= 'body, p, .entry-content, .widget, .site-description { font-family: ' . $formatted_body_font . '; }';
    }
    
    $heading_font = get_theme_mod( 'mec_theme_heading_font_family', 'default' );
    $formatted_heading_font = mec_theme_format_font_family( $heading_font );
    if ( $formatted_heading_font ) {
        $css .= 'h1, h2, h3, h4, h5, h6, .entry-title, .widget-title { font-family: ' . $formatted_heading_font . '; }';
    }
    
    // Menu padding and spacing
    $menu_padding = get_theme_mod( 'mec_theme_menu_padding', 10 );
    $css .= '.main-navigation a { padding: ' . absint( $menu_padding ) . 'px 0; }';
    
    $menu_spacing = get_theme_mod( 'mec_theme_menu_spacing', 20 );
    $css .= '.main-navigation ul { gap: ' . absint( $menu_spacing ) . 'px; }';
    
    // Footer padding
    $footer_padding = get_theme_mod( 'mec_theme_footer_padding', 40 );
    $css .= '.site-footer { padding: ' . absint( $footer_padding ) . 'px 0 20px; }';
    
    // Sidebar widths
    $content_width = get_theme_mod( 'mec_theme_content_width', 70 );
    $sidebar_width = get_theme_mod( 'mec_theme_sidebar_width', 25 );
    if ( $content_width && $sidebar_width ) {
        $css .= '.has-sidebar .primary { flex: 1 1 ' . absint( $content_width ) . '%; }';
        $css .= '.has-sidebar .secondary { flex: 1 1 ' . absint( $sidebar_width ) . '%; }';
    }
    
    // Logo max widths
    $logo_desktop = get_theme_mod( 'mec_theme_logo_max_width_desktop', 200 );
    $css .= '@media (min-width: 769px) { .custom-logo { max-width: ' . absint( $logo_desktop ) . 'px; } }';
    
    $logo_tablet = get_theme_mod( 'mec_theme_logo_max_width_tablet', 150 );
    $css .= '@media (min-width: 481px) and (max-width: 768px) { .custom-logo { max-width: ' . absint( $logo_tablet ) . 'px; } }';
    
    $logo_mobile = get_theme_mod( 'mec_theme_logo_max_width_mobile', 120 );
    $css .= '@media (max-width: 480px) { .custom-logo { max-width: ' . absint( $logo_mobile ) . 'px; } }';
    
    // Sticky header
    if ( get_theme_mod( 'mec_theme_sticky_header', false ) ) {
        $css .= '.site-header { position: sticky; top: 0; z-index: 100; }';
    }
    
    return $css;
}

/**
 * Generate responsive font size CSS using CSS variables
 */
function mec_theme_get_responsive_css() {
    $css = '';
    
    // Desktop
    $body_font_desktop = get_theme_mod( 'mec_theme_body_font_size_desktop', 16 );
    $css .= '@media (min-width: 769px) { body { font-size: ' . absint( $body_font_desktop ) . 'px; } }';
    
    $title_size_desktop = get_theme_mod( 'mec_theme_site_title_size_desktop', '1.8' );
    $css .= '@media (min-width: 769px) { .site-title { font-size: ' . floatval( $title_size_desktop ) . 'rem; } }';
    
    $tagline_size_desktop = get_theme_mod( 'mec_theme_tagline_size_desktop', '1' );
    $css .= '@media (min-width: 769px) { .site-tagline { font-size: ' . floatval( $tagline_size_desktop ) . 'rem; } }';
    
    $desc_size_desktop = get_theme_mod( 'mec_theme_description_size_desktop', '0.9' );
    $css .= '@media (min-width: 769px) { .site-description { font-size: ' . floatval( $desc_size_desktop ) . 'rem; } }';
    
    $heading_size_desktop = get_theme_mod( 'mec_theme_heading_size_desktop', '2' );
    $css .= '@media (min-width: 769px) { .entry-title { font-size: ' . floatval( $heading_size_desktop ) . 'rem; } }';
    
    $menu_size_desktop = get_theme_mod( 'mec_theme_menu_size_desktop', '1' );
    $css .= '@media (min-width: 769px) { .main-navigation a { font-size: ' . floatval( $menu_size_desktop ) . 'rem; } }';
    
    // Tablet
    $body_font_tablet = get_theme_mod( 'mec_theme_body_font_size_tablet', 15 );
    $css .= '@media (min-width: 481px) and (max-width: 768px) { body { font-size: ' . absint( $body_font_tablet ) . 'px; } }';
    
    $title_size_tablet = get_theme_mod( 'mec_theme_site_title_size_tablet', '1.5' );
    $css .= '@media (min-width: 481px) and (max-width: 768px) { .site-title { font-size: ' . floatval( $title_size_tablet ) . 'rem; } }';
    
    $tagline_size_tablet = get_theme_mod( 'mec_theme_tagline_size_tablet', '0.9' );
    $css .= '@media (min-width: 481px) and (max-width: 768px) { .site-tagline { font-size: ' . floatval( $tagline_size_tablet ) . 'rem; } }';
    
    $desc_size_tablet = get_theme_mod( 'mec_theme_description_size_tablet', '0.85' );
    $css .= '@media (min-width: 481px) and (max-width: 768px) { .site-description { font-size: ' . floatval( $desc_size_tablet ) . 'rem; } }';
    
    $heading_size_tablet = get_theme_mod( 'mec_theme_heading_size_tablet', '1.7' );
    $css .= '@media (min-width: 481px) and (max-width: 768px) { .entry-title { font-size: ' . floatval( $heading_size_tablet ) . 'rem; } }';
    
    $menu_size_tablet = get_theme_mod( 'mec_theme_menu_size_tablet', '0.95' );
    $css .= '@media (min-width: 481px) and (max-width: 768px) { .main-navigation a { font-size: ' . floatval( $menu_size_tablet ) . 'rem; } }';
    
    // Mobile
    $body_font_mobile = get_theme_mod( 'mec_theme_body_font_size_mobile', 14 );
    $css .= '@media (max-width: 480px) { body { font-size: ' . absint( $body_font_mobile ) . 'px; } }';
    
    $title_size_mobile = get_theme_mod( 'mec_theme_site_title_size_mobile', '1.3' );
    $css .= '@media (max-width: 480px) { .site-title { font-size: ' . floatval( $title_size_mobile ) . 'rem; } }';
    
    $tagline_size_mobile = get_theme_mod( 'mec_theme_tagline_size_mobile', '0.85' );
    $css .= '@media (max-width: 480px) { .site-tagline { font-size: ' . floatval( $tagline_size_mobile ) . 'rem; } }';
    
    $desc_size_mobile = get_theme_mod( 'mec_theme_description_size_mobile', '0.8' );
    $css .= '@media (max-width: 480px) { .site-description { font-size: ' . floatval( $desc_size_mobile ) . 'rem; } }';
    
    $heading_size_mobile = get_theme_mod( 'mec_theme_heading_size_mobile', '1.5' );
    $css .= '@media (max-width: 480px) { .entry-title { font-size: ' . floatval( $heading_size_mobile ) . 'rem; } }';
    
    $menu_size_mobile = get_theme_mod( 'mec_theme_menu_size_mobile', '0.9' );
    $css .= '@media (max-width: 480px) { .main-navigation a { font-size: ' . floatval( $menu_size_mobile ) . 'rem; } }';
    
    return $css;
}

/**
 * Generate submenu font sizes (desktop, tablet, mobile)
 */
function mec_theme_get_submenu_font_sizes_css() {
    $css = '';
    $submenu_desktop = get_theme_mod( 'mec_theme_submenu_size_desktop', '0.95' );
    $submenu_tablet  = get_theme_mod( 'mec_theme_submenu_size_tablet', '0.9' );
    $submenu_mobile  = get_theme_mod( 'mec_theme_submenu_size_mobile', '0.85' );
    
    if ( $submenu_desktop ) {
        $css .= '@media (min-width: 769px) { .main-navigation ul ul a { font-size: ' . esc_attr( $submenu_desktop ) . 'rem; } }';
    }
    if ( $submenu_tablet ) {
        $css .= '@media (min-width: 481px) and (max-width: 768px) { .main-navigation ul ul a { font-size: ' . esc_attr( $submenu_tablet ) . 'rem; } }';
    }
    if ( $submenu_mobile ) {
        $css .= '@media (max-width: 480px) { .main-navigation ul ul a { font-size: ' . esc_attr( $submenu_mobile ) . 'rem; } }';
    }
    return $css;
}

/**
 * Generate mobile menu colours CSS (excluding submenu font sizes)
 */
function mec_theme_get_mobile_menu_colors_css() {
    $css = '@media (max-width: 768px) {';
    
    $mobile_bg = get_theme_mod( 'mec_theme_mobile_menu_bg', '#ffffff' );
    if ( $mobile_bg && preg_match( '/^#[a-f0-9]{6}$/i', $mobile_bg ) ) {
        $css .= '.main-navigation ul { background-color: ' . esc_attr( $mobile_bg ) . '; }';
    }
    
    $mobile_text = get_theme_mod( 'mec_theme_mobile_menu_text', '#3a3a3a' );
    if ( $mobile_text && preg_match( '/^#[a-f0-9]{6}$/i', $mobile_text ) ) {
        $css .= '.main-navigation a { color: ' . esc_attr( $mobile_text ) . '; }';
    }
    
    $mobile_hover_bg = get_theme_mod( 'mec_theme_mobile_menu_hover_bg', '#f8f9fa' );
    $mobile_hover_text = get_theme_mod( 'mec_theme_mobile_menu_hover_text', '#0274be' );
    if ( $mobile_hover_bg || $mobile_hover_text ) {
        $css .= '.main-navigation a:hover {';
        if ( $mobile_hover_bg && preg_match( '/^#[a-f0-9]{6}$/i', $mobile_hover_bg ) ) {
            $css .= 'background-color: ' . esc_attr( $mobile_hover_bg ) . ';';
        }
        if ( $mobile_hover_text && preg_match( '/^#[a-f0-9]{6}$/i', $mobile_hover_text ) ) {
            $css .= 'color: ' . esc_attr( $mobile_hover_text ) . ';';
        }
        $css .= '}';
    }
    
    // Hamburger button colours
    $hamburger_bg = get_theme_mod( 'mec_theme_hamburger_bg', 'transparent' );
    $hamburger_color = get_theme_mod( 'mec_theme_hamburger_color', '#3a3a3a' );
    $hamburger_hover_bg = get_theme_mod( 'mec_theme_hamburger_hover_bg', 'transparent' );
    $hamburger_hover_color = get_theme_mod( 'mec_theme_hamburger_hover_color', '#0274be' );
    
    if ( $hamburger_bg && 'transparent' !== $hamburger_bg && preg_match( '/^#[a-f0-9]{6}$/i', $hamburger_bg ) ) {
        $css .= '.menu-toggle { background-color: ' . esc_attr( $hamburger_bg ) . ' !important; }';
    } elseif ( 'transparent' === $hamburger_bg ) {
        $css .= '.menu-toggle { background-color: transparent !important; }';
    }
    if ( $hamburger_color && preg_match( '/^#[a-f0-9]{6}$/i', $hamburger_color ) ) {
        $css .= '.menu-toggle, .menu-toggle::before { color: ' . esc_attr( $hamburger_color ) . ' !important; }';
    }
    if ( $hamburger_hover_bg && 'transparent' !== $hamburger_hover_bg && preg_match( '/^#[a-f0-9]{6}$/i', $hamburger_hover_bg ) ) {
        $css .= '.menu-toggle:hover { background-color: ' . esc_attr( $hamburger_hover_bg ) . ' !important; }';
    } elseif ( 'transparent' === $hamburger_hover_bg ) {
        $css .= '.menu-toggle:hover { background-color: transparent !important; }';
    }
    if ( $hamburger_hover_color && preg_match( '/^#[a-f0-9]{6}$/i', $hamburger_hover_color ) ) {
        $css .= '.menu-toggle:hover, .menu-toggle:hover::before { color: ' . esc_attr( $hamburger_hover_color ) . ' !important; }';
    }
    
    // Hamburger size – separate selectors, no nesting
    $hamburger_width = get_theme_mod( 'mec_theme_hamburger_width', '40' );
    $hamburger_height = get_theme_mod( 'mec_theme_hamburger_height', '40' );
    $hamburger_font = get_theme_mod( 'mec_theme_hamburger_font_size', '1.2' );
    
    if ( $hamburger_width || $hamburger_height || $hamburger_font ) {
        $css .= '.menu-toggle {';
        if ( $hamburger_width ) {
            $css .= 'min-width: ' . absint( $hamburger_width ) . 'px; width: auto;';
        }
        if ( $hamburger_height ) {
            $css .= 'height: ' . absint( $hamburger_height ) . 'px; line-height: ' . absint( $hamburger_height ) . 'px;';
        }
        if ( $hamburger_font ) {
            $css .= 'font-size: 0;';
        }
        $css .= '}';
        if ( $hamburger_font ) {
            $css .= '.menu-toggle::before { font-size: ' . esc_attr( $hamburger_font ) . 'rem; line-height: ' . absint( $hamburger_height ) . 'px; }';
        }
    }
    
    $css .= '}'; // close @media (max-width: 768px)
    
    // Hide description on tablet/mobile
    if ( get_theme_mod( 'mec_theme_hide_description_tablet', false ) ) {
        $css .= '@media (min-width: 481px) and (max-width: 768px) { .site-description { display: none !important; } }';
    }
    if ( get_theme_mod( 'mec_theme_hide_description_mobile', false ) ) {
        $css .= '@media (max-width: 480px) { .site-description { display: none !important; } }';
    }
    
    // Contact column hiding
    $hide_contact_tablet = get_theme_mod( 'mec_theme_hide_contact_tablet', false );
    $hide_contact_mobile = get_theme_mod( 'mec_theme_hide_contact_mobile', false );
    if ( $hide_contact_tablet ) {
        $css .= '@media (min-width: 481px) and (max-width: 768px) { .header-contact-column { display: none !important; } }';
    }
    if ( $hide_contact_mobile ) {
        $css .= '@media (max-width: 480px) { .header-contact-column { display: none !important; } }';
    }
    
    return $css;
}

/**
 * Get cached customizer CSS (now includes submenu font sizes)
 */
function mec_theme_get_customizer_css() {
    $css = '';
    
    // Root CSS variables (these override the defaults in style.css)
    $css .= mec_theme_get_root_variables_css();
    
    // Static rules that use variables
    $css .= mec_theme_get_static_rules_css();
    
    // Responsive font sizes
    $css .= mec_theme_get_responsive_css();
    
    // Submenu font sizes (desktop, tablet, mobile)
    $css .= mec_theme_get_submenu_font_sizes_css();
    
    // Mobile menu colours and additional overrides
    $css .= mec_theme_get_mobile_menu_colors_css();
    
    // Contact phone/email colours (specific selectors)
    $phone_color = get_theme_mod( 'mec_theme_contact_phone_color', '#333333' );
    if ( $phone_color && preg_match( '/^#[a-f0-9]{6}$/i', $phone_color ) ) {
        $css .= '.header-contact-column .contact-phone { color: ' . esc_attr( $phone_color ) . '; }';
    }
    $email_color = get_theme_mod( 'mec_theme_contact_email_color', '#333333' );
    if ( $email_color && preg_match( '/^#[a-f0-9]{6}$/i', $email_color ) ) {
        $css .= '.header-contact-column .contact-email a { color: ' . esc_attr( $email_color ) . '; }';
    }
    
    // Site title colour (using variable but also direct for older browsers)
    $site_title_color = get_theme_mod( 'mec_theme_site_title_color', '#333333' );
    $css .= '.site-title a { color: ' . esc_attr( $site_title_color ) . '; }';
    
    // Body line height
    $line_height = get_theme_mod( 'mec_theme_body_line_height', '1.6' );
    $css .= 'body { line-height: ' . floatval( $line_height ) . '; }';
    
    return $css;
}

/**
 * Cache customizer CSS
 */
function mec_theme_get_cached_customizer_css() {
    $cache_key = 'mec_theme_customizer_css';
    $css = get_transient( $cache_key );
    if ( false === $css ) {
        $css = mec_theme_get_customizer_css();
        set_transient( $cache_key, $css, DAY_IN_SECONDS );
    }
    return $css;
}

/**
 * Clear customizer CSS cache
 */
function mec_theme_clear_customizer_cache() {
    delete_transient( 'mec_theme_customizer_css' );
}
add_action( 'customize_save_after', 'mec_theme_clear_customizer_cache' );
add_action( 'update_option_theme_mods_' . get_stylesheet(), 'mec_theme_clear_customizer_cache' );

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
 * Sanitization function for text alignment
 */
function mec_theme_sanitize_text_align( $input ) {
    $valid = array( 'left', 'center', 'right' );
    return in_array( $input, $valid, true ) ? $input : 'left';
}

/**
 * Validate hex color
 */
function mec_theme_validate_hex_color( $color, $default = '' ) {
    if ( preg_match( '/^#[a-f0-9]{6}$/i', $color ) ) {
        return $color;
    }
    return $default;
}

// Include customizer settings
require_once get_template_directory() . '/inc/customizer.php';

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

/**
 * Format font family for CSS
 *
 * Defense-in-depth: even though the theme_mod values passed in here are
 * already restricted to a fixed whitelist at the Customizer sanitize_callback
 * layer (see mec_theme_sanitize_body_font_family / _heading_font_family),
 * this function is the last stop before the value is concatenated into a
 * raw <style> block via wp_add_inline_style(). Reject anything containing
 * characters that aren't valid in a CSS font-family value, so this can never
 * become an injection point again if the whitelist is ever loosened or bypassed.
 */
function mec_theme_format_font_family( $font_setting ) {
    if ( ! $font_setting || 'default' === $font_setting ) {
        return '';
    }
    // Only allow letters, numbers, spaces, hyphens, commas and quotes.
    if ( preg_match( '/[^A-Za-z0-9 ,\'"\-]/', $font_setting ) ) {
        return '';
    }
    if ( preg_match( '/^([\'"]?.+?[\'"]?)(?:,\s*(.+))?$/', $font_setting, $matches ) ) {
        $specific = trim( $matches[1] );
        $generic = isset( $matches[2] ) ? ',' . trim( $matches[2] ) : '';
        if ( strpos( $specific, ' ' ) !== false && strpos( $specific, '"' ) === false && strpos( $specific, "'" ) === false ) {
            $specific = '"' . $specific . '"';
        }
        return $specific . $generic;
    }
    return '';
}

/**
 * Add Contact & Social fields to Customizer
 */
function mec_theme_customize_contact_social( $wp_customize ) {
    
    // New section: Contact & Social
    $wp_customize->add_section( 'mec_theme_contact_social_section', array(
        'title'    => __( 'Contact & Social (Header)', 'mec_theme' ),
        'priority' => 35, // after Header section
    ) );
    
    // Phone number 1
    $wp_customize->add_setting( 'mec_theme_phone_1', array(
        'default'           => '+1 (234) 567-8901',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'mec_theme_phone_1', array(
        'label'       => __( 'Phone Number 1', 'mec_theme' ),
        'section'     => 'mec_theme_contact_social_section',
        'type'        => 'text',
    ) );
    
    // Phone number 2
    $wp_customize->add_setting( 'mec_theme_phone_2', array(
        'default'           => '+1 (234) 567-8902',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'mec_theme_phone_2', array(
        'label'       => __( 'Phone Number 2', 'mec_theme' ),
        'section'     => 'mec_theme_contact_social_section',
        'type'        => 'text',
    ) );
    
    // Email address
    $wp_customize->add_setting( 'mec_theme_email', array(
        'default'           => 'info@yournonprofit.org',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'mec_theme_email', array(
        'label'       => __( 'Email Address', 'mec_theme' ),
        'section'     => 'mec_theme_contact_social_section',
        'type'        => 'email',
    ) );
    
    // Social: Facebook
    $wp_customize->add_setting( 'mec_theme_facebook_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'mec_theme_facebook_url', array(
        'label'       => __( 'Facebook URL', 'mec_theme' ),
        'section'     => 'mec_theme_contact_social_section',
        'type'        => 'url',
    ) );
    
    // Social: Twitter
    $wp_customize->add_setting( 'mec_theme_twitter_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'mec_theme_twitter_url', array(
        'label'       => __( 'Twitter/X URL', 'mec_theme' ),
        'section'     => 'mec_theme_contact_social_section',
        'type'        => 'url',
    ) );
    
    // Social: Instagram
    $wp_customize->add_setting( 'mec_theme_instagram_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'mec_theme_instagram_url', array(
        'label'       => __( 'Instagram URL', 'mec_theme' ),
        'section'     => 'mec_theme_contact_social_section',
        'type'        => 'url',
    ) );
    
    // Optional: LinkedIn
    $wp_customize->add_setting( 'mec_theme_linkedin_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'mec_theme_linkedin_url', array(
        'label'       => __( 'LinkedIn URL (optional)', 'mec_theme' ),
        'section'     => 'mec_theme_contact_social_section',
        'type'        => 'url',
    ) );
    
    // Optional: YouTube
    $wp_customize->add_setting( 'mec_theme_youtube_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'mec_theme_youtube_url', array(
        'label'       => __( 'YouTube URL (optional)', 'mec_theme' ),
        'section'     => 'mec_theme_contact_social_section',
        'type'        => 'url',
    ) );

    // Contact text colors (phone & email)
    $wp_customize->add_setting( 'mec_theme_contact_phone_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_contact_phone_color', array(
        'label'    => __( 'Phone Numbers Color', 'mec_theme' ),
        'section'  => 'mec_theme_contact_social_section',
    ) ) );

    $wp_customize->add_setting( 'mec_theme_contact_email_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_contact_email_color', array(
        'label'    => __( 'Email Address Color', 'mec_theme' ),
        'section'  => 'mec_theme_contact_social_section',
    ) ) );

    // Hide contact column on tablet and mobile
    $wp_customize->add_setting( 'mec_theme_hide_contact_tablet', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'mec_theme_hide_contact_tablet', array(
        'label'       => __( 'Hide contact column on tablet (481px - 768px)', 'mec_theme' ),
        'section'     => 'mec_theme_contact_social_section',
        'type'        => 'checkbox',
    ) );

    $wp_customize->add_setting( 'mec_theme_hide_contact_mobile', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'mec_theme_hide_contact_mobile', array(
        'label'       => __( 'Hide contact column on mobile (=480px)', 'mec_theme' ),
        'section'     => 'mec_theme_contact_social_section',
        'type'        => 'checkbox',
    ) );
}
add_action( 'customize_register', 'mec_theme_customize_contact_social' );

/**
 * Output CSS to hide contact column based on Customizer settings
 */
function mec_theme_hide_contact_css() {
    $hide_tablet = get_theme_mod( 'mec_theme_hide_contact_tablet', false );
    $hide_mobile = get_theme_mod( 'mec_theme_hide_contact_mobile', false );
    
    if ( ! $hide_tablet && ! $hide_mobile ) {
        return;
    }
    
    echo '<style type="text/css">';
    if ( $hide_tablet ) {
        echo '@media (min-width: 481px) and (max-width: 768px) { .header-contact-column { display: none !important; } }';
    }
    if ( $hide_mobile ) {
        echo '@media (max-width: 480px) { .header-contact-column { display: none !important; } }';
    }
    echo '</style>';
}
add_action( 'wp_head', 'mec_theme_hide_contact_css', 20 );

/**
 * Optional: Live preview JavaScript for contact fields
 */
function mec_theme_customize_contact_preview() {
    if ( ! is_customize_preview() ) {
        return;
    }
    ?>
    <script type="text/javascript">
    ( function( $ ) {
        wp.customize( 'mec_theme_phone_1', function( value ) {
            value.bind( function( newval ) {
                $( '.contact-phone-1' ).text( newval );
            } );
        } );
        wp.customize( 'mec_theme_phone_2', function( value ) {
            value.bind( function( newval ) {
                $( '.contact-phone-2' ).text( newval );
            } );
        } );
        wp.customize( 'mec_theme_email', function( value ) {
            value.bind( function( newval ) {
                $( '.contact-email a' ).attr( 'href', 'mailto:' + newval ).text( newval );
            } );
        } );
        function updateSocial( settingId, selector ) {
            wp.customize( settingId, function( value ) {
                value.bind( function( newval ) {
                    $( selector ).attr( 'href', newval );
                } );
            } );
        }
        updateSocial( 'mec_theme_facebook_url', '.social-icon-facebook' );
        updateSocial( 'mec_theme_twitter_url', '.social-icon-twitter' );
        updateSocial( 'mec_theme_instagram_url', '.social-icon-instagram' );
        updateSocial( 'mec_theme_linkedin_url', '.social-icon-linkedin' );
        updateSocial( 'mec_theme_youtube_url', '.social-icon-youtube' );

        // Live preview for contact phone and email colors
        wp.customize( 'mec_theme_contact_phone_color', function( value ) {
            value.bind( function( newval ) {
                $( '.contact-phone' ).css( 'color', newval );
            } );
        } );
        wp.customize( 'mec_theme_contact_email_color', function( value ) {
            value.bind( function( newval ) {
                $( '.contact-email a' ).css( 'color', newval );
            } );
        } );

        // Live preview for hiding contact column
        function updateContactVisibility() {
            var hideTablet = wp.customize( 'mec_theme_hide_contact_tablet' ).get();
            var hideMobile = wp.customize( 'mec_theme_hide_contact_mobile' ).get();
            var styleId = 'mec-theme-hide-contact-preview';
            var $style = $('#' + styleId);
            if ( $style.length === 0 ) {
                $style = $('<style id="' + styleId + '"></style>').appendTo('head');
            }
            var css = '';
            if ( hideTablet ) {
                css += '@media (min-width: 481px) and (max-width: 768px) { .header-contact-column { display: none !important; } }';
            }
            if ( hideMobile ) {
                css += '@media (max-width: 480px) { .header-contact-column { display: none !important; } }';
            }
            $style.html(css);
        }
        wp.customize( 'mec_theme_hide_contact_tablet', function( value ) {
            value.bind( updateContactVisibility );
        } );
        wp.customize( 'mec_theme_hide_contact_mobile', function( value ) {
            value.bind( updateContactVisibility );
        } );
        updateContactVisibility();
    } )( jQuery );
    </script>
    <?php
}
add_action( 'wp_footer', 'mec_theme_customize_contact_preview' );

// ===== SOCIAL ICON CUSTOMIZATION (Size & Colors) =====
function mec_theme_social_icon_customizer( $wp_customize ) {
    // Add settings to existing section 'mec_theme_contact_social_section'
    $section = 'mec_theme_contact_social_section';
    
    // Social icon size (width/height in pixels)
    $wp_customize->add_setting( 'mec_theme_social_icon_size', array(
        'default'           => 36,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'mec_theme_social_icon_size', array(
        'label'       => __( 'Social Icon Size (px)', 'mec_theme' ),
        'section'     => $section,
        'type'        => 'number',
        'input_attrs' => array( 'min' => 24, 'max' => 60, 'step' => 2 ),
    ) );
    
    // Social icon font/svg size (px)
    $wp_customize->add_setting( 'mec_theme_social_icon_font_size', array(
        'default'           => 18,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'mec_theme_social_icon_font_size', array(
        'label'       => __( 'Social Icon SVG Size (px)', 'mec_theme' ),
        'section'     => $section,
        'type'        => 'number',
        'input_attrs' => array( 'min' => 12, 'max' => 40, 'step' => 2 ),
    ) );
    
    // Social icon background color
    $wp_customize->add_setting( 'mec_theme_social_icon_bg', array(
        'default'           => '#e0e0e0',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_social_icon_bg', array(
        'label'    => __( 'Social Icon Background Color', 'mec_theme' ),
        'section'  => $section,
    ) ) );
    
    // Social icon color
    $wp_customize->add_setting( 'mec_theme_social_icon_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_social_icon_color', array(
        'label'    => __( 'Social Icon Color', 'mec_theme' ),
        'section'  => $section,
    ) ) );
    
    // Social icon hover background color
    $wp_customize->add_setting( 'mec_theme_social_icon_hover_bg', array(
        'default'           => '#cccccc',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_social_icon_hover_bg', array(
        'label'    => __( 'Social Icon Hover Background Color', 'mec_theme' ),
        'section'  => $section,
    ) ) );
    
    // Social icon hover color
    $wp_customize->add_setting( 'mec_theme_social_icon_hover_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_social_icon_hover_color', array(
        'label'    => __( 'Social Icon Hover Color', 'mec_theme' ),
        'section'  => $section,
    ) ) );
}
add_action( 'customize_register', 'mec_theme_social_icon_customizer' );

// Output CSS variables for social icons
function mec_theme_social_icon_css() {
    $size = get_theme_mod( 'mec_theme_social_icon_size', 36 );
    $font_size = get_theme_mod( 'mec_theme_social_icon_font_size', 18 );
    $bg = get_theme_mod( 'mec_theme_social_icon_bg', '#e0e0e0' );
    $color = get_theme_mod( 'mec_theme_social_icon_color', '#333333' );
    $hover_bg = get_theme_mod( 'mec_theme_social_icon_hover_bg', '#cccccc' );
    $hover_color = get_theme_mod( 'mec_theme_social_icon_hover_color', '#ffffff' );
    ?>
    <style type="text/css">
        :root {
            --social-icon-size: <?php echo absint( $size ); ?>px;
            --social-icon-font-size: <?php echo absint( $font_size ); ?>px;
            --social-icon-bg: <?php echo esc_attr( $bg ); ?>;
            --social-icon-color: <?php echo esc_attr( $color ); ?>;
            --social-icon-hover-bg: <?php echo esc_attr( $hover_bg ); ?>;
            --social-icon-hover-color: <?php echo esc_attr( $hover_color ); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'mec_theme_social_icon_css', 20 );
?>