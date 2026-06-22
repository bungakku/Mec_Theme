<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * The header for our theme
 *
 * @package MEC_Theme
 * @version 1.7.6
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
} else {
    do_action( 'wp_body_open' );
}
?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary">
        <?php esc_html_e( 'Skip to content', 'mec_theme' ); ?>
    </a>

    <header id="masthead" class="site-header">
        <div class="container">
            <?php
            $logo_pos_desktop = get_theme_mod( 'mec_theme_logo_position_desktop', get_theme_mod( 'mec_theme_logo_position', 'left' ) );
            $logo_pos_tablet  = get_theme_mod( 'mec_theme_logo_position_tablet', get_theme_mod( 'mec_theme_logo_position', 'left' ) );
            $logo_pos_mobile  = get_theme_mod( 'mec_theme_logo_position_mobile', get_theme_mod( 'mec_theme_logo_position', 'left' ) );

            $title_align_desktop = get_theme_mod( 'mec_theme_title_align_desktop', 'left' );
            $title_align_tablet  = get_theme_mod( 'mec_theme_title_align_tablet', 'left' );
            $title_align_mobile  = get_theme_mod( 'mec_theme_title_align_mobile', 'left' );
            ?>

            <div class="header-top-row">
                <div class="site-branding
                    logo-pos-desktop-<?php echo esc_attr( $logo_pos_desktop ); ?> 
                    logo-pos-tablet-<?php echo esc_attr( $logo_pos_tablet ); ?> 
                    logo-pos-mobile-<?php echo esc_attr( $logo_pos_mobile ); ?>
                    title-align-desktop-<?php echo esc_attr( $title_align_desktop ); ?> 
                    title-align-tablet-<?php echo esc_attr( $title_align_tablet ); ?> 
                    title-align-mobile-<?php echo esc_attr( $title_align_mobile ); ?>
                ">
                    <div class="logo-text-wrapper">
                        <?php
                        if ( has_custom_logo() ) {
                            the_custom_logo();
                        }
                        ?>
                        <div class="site-text">
                            <?php if ( is_front_page() && is_home() ) : ?>
                                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                            <?php else : ?>
                                <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                            <?php endif; ?>

                            <?php
                            $default_tagline = get_bloginfo( 'description', 'display' );
                            if ( ! empty( $default_tagline ) ) {
                                echo '<p class="site-tagline">' . esc_html( $default_tagline ) . '</p>';
                            }

                            $show_custom_description = get_theme_mod( 'mec_theme_show_description', true );
                            $custom_description       = get_theme_mod( 'mec_theme_custom_description', '' );
                            if ( $show_custom_description && ! empty( $custom_description ) ) {
                                echo '<div class="site-description">' . wp_kses_post( $custom_description ) . '</div>';
                            }
                            ?>
                        </div><!-- .site-text -->
                    </div><!-- .logo-text-wrapper -->
                </div><!-- .site-branding -->

                <div class="header-contact-column">
                    <?php 
                    $phone1 = get_theme_mod( 'mec_theme_phone_1', '+1 (234) 567-8901' );
                    if ( ! empty( $phone1 ) ) : ?>
                        <div class="contact-phone contact-phone-1"><?php echo esc_html( $phone1 ); ?></div>
                    <?php endif; ?>

                    <?php 
                    $phone2 = get_theme_mod( 'mec_theme_phone_2', '+1 (234) 567-8902' );
                    if ( ! empty( $phone2 ) ) : ?>
                        <div class="contact-phone contact-phone-2"><?php echo esc_html( $phone2 ); ?></div>
                    <?php endif; ?>

                    <?php 
                    $email = get_theme_mod( 'mec_theme_email', 'info@yournonprofit.org' );
                    if ( ! empty( $email ) ) : ?>
                        <div class="contact-email">
                            <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
                        </div>
                    <?php endif; ?>

                    <div class="contact-social">
                        <?php 
                        $facebook = get_theme_mod( 'mec_theme_facebook_url', '#' );
                        if ( ! empty( $facebook ) && '#' !== $facebook ) : ?>
                            <a href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener noreferrer" class="social-icon social-icon-facebook" aria-label="<?php esc_attr_e( 'Visit our Facebook page', 'mec_theme' ); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true" focusable="false">
                                    <path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/>
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php 
                        $twitter = get_theme_mod( 'mec_theme_twitter_url', '#' );
                        if ( ! empty( $twitter ) && '#' !== $twitter ) : ?>
                            <a href="<?php echo esc_url( $twitter ); ?>" target="_blank" rel="noopener noreferrer" class="social-icon social-icon-twitter" aria-label="<?php esc_attr_e( 'Visit our Twitter page', 'mec_theme' ); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true" focusable="false">
                                    <path d="M23.44 4.83c-.8.37-1.5.38-2.22.02.93-.56.98-.96 1.32-2.02-.88.52-1.86.9-2.9 1.1-.82-.88-2-1.43-3.3-1.43-2.5 0-4.55 2.04-4.55 4.55 0 .36.03.7.1 1.04-3.77-.2-7.12-2-9.36-4.75-.4.67-.6 1.45-.6 2.28 0 1.56.8 2.95 2 3.77-.74-.03-1.44-.23-2.05-.57v.06c0 2.2 1.56 4.03 3.64 4.44-.67.2-1.37.2-2.06.08.58 1.8 2.26 3.12 4.25 3.16C6.78 18.1 4.85 19 2.8 19c-.36 0-.72-.02-1.08-.07 2.02 1.3 4.42 2.05 7 2.05 8.4 0 13-6.96 13-13 0-.2 0-.4-.02-.6.9-.64 1.68-1.45 2.3-2.38z"/>
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php 
                        $instagram = get_theme_mod( 'mec_theme_instagram_url', '#' );
                        if ( ! empty( $instagram ) && '#' !== $instagram ) : ?>
                            <a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener noreferrer" class="social-icon social-icon-instagram" aria-label="<?php esc_attr_e( 'Visit our Instagram page', 'mec_theme' ); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true" focusable="false">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 110 2.881 1.44 1.44 0 010-2.881z"/>
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php 
                        $linkedin = get_theme_mod( 'mec_theme_linkedin_url', '' );
                        if ( ! empty( $linkedin ) ) : ?>
                            <a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer" class="social-icon social-icon-linkedin" aria-label="<?php esc_attr_e( 'Visit our LinkedIn page', 'mec_theme' ); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true" focusable="false">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C0.792 0 0 0.774 0 1.729v20.542C0 23.227 0.792 24 1.771 24h20.451c0.979 0 1.771-0.773 1.771-1.729V1.729C24 0.774 23.203 0 22.225 0z"/>
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php 
                        $youtube = get_theme_mod( 'mec_theme_youtube_url', '' );
                        if ( ! empty( $youtube ) ) : ?>
                            <a href="<?php echo esc_url( $youtube ); ?>" target="_blank" rel="noopener noreferrer" class="social-icon social-icon-youtube" aria-label="<?php esc_attr_e( 'Visit our YouTube channel', 'mec_theme' ); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true" focusable="false">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.376.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.376-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div><!-- .contact-social -->
                </div><!-- .header-contact-column -->
            </div><!-- .header-top-row -->

            <nav id="site-navigation" class="main-navigation">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    ☰ <?php esc_html_e( 'Menu', 'mec_theme' ); ?>
                </button>

                <div class="mobile-menu-panel">
                    <button class="mobile-menu-close" aria-label="<?php esc_attr_e( 'Close menu', 'mec_theme' ); ?>">
                        ✕ <span class="screen-reader-text"><?php esc_html_e( 'Close menu', 'mec_theme' ); ?></span>
                    </button>
                    <div class="mobile-search-form">
                        <?php get_search_form(); ?>
                    </div>
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                            'container'      => false,
                            'fallback_cb'    => 'wp_page_menu', // ✅ Shows pages if no menu assigned
                            'depth'          => 3,
                        )
                    );
                    ?>
                </div><!-- .mobile-menu-panel -->
            </nav><!-- #site-navigation -->

            <?php if ( is_active_sidebar( 'header-widget' ) ) : ?>
                <div class="header-widget-area">
                    <?php dynamic_sidebar( 'header-widget' ); ?>
                </div>
            <?php endif; ?>
        </div><!-- .container -->
    </header><!-- #masthead -->

    <div id="content" class="site-content">