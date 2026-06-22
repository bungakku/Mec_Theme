<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Contact & Social Customizer panel: phone numbers, email, social links,
 * social icon styling, and their front-end CSS/live-preview output.
 *
 * Extracted from functions.php during the 1.7.4 file-organization pass.
 * No behavior changed.
 *
 * @package MEC_Theme
 * @version 1.7.4
 */

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
