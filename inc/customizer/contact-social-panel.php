<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Contact & Social Customizer panel: phone numbers, email, social links,
 * social icon styling, and their front-end CSS/live-preview output.
 *
 * Extracted from functions.php during the 1.7.1 file-organization pass.
 * No behavior changed.
 *
 * @package MEC_Theme
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

    // --- Independent block visibility toggles: tablet + mobile only ---
    // These hide each block via CSS at <=768px (tablet + mobile combined),
    // matching the existing mec_theme_hide_contact_tablet/mobile pattern
    // just below -- desktop (>768px) always shows all three blocks
    // regardless of these settings. 'postMessage' transport is used since
    // this is purely a CSS display toggle at a breakpoint, live-previewed
    // via updateContactVisibility() in mec_theme_customize_contact_preview()
    // further down this file, the same way hide_contact_tablet/mobile
    // already is.
    $wp_customize->add_setting( 'mec_theme_show_contact_phones', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'mec_theme_show_contact_phones', array(
        'label'       => __( 'Show Phone Numbers (Tablet & Mobile)', 'mec_theme' ),
        'description' => __( 'Applies at 768px wide and below only. Desktop always shows phone numbers.', 'mec_theme' ),
        'section'     => 'mec_theme_contact_social_section',
        'type'        => 'checkbox',
        'priority'    => 5,
    ) );

    $wp_customize->add_setting( 'mec_theme_show_contact_email', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'mec_theme_show_contact_email', array(
        'label'       => __( 'Show Email Address (Tablet & Mobile)', 'mec_theme' ),
        'description' => __( 'Applies at 768px wide and below only. Desktop always shows the email address.', 'mec_theme' ),
        'section'     => 'mec_theme_contact_social_section',
        'type'        => 'checkbox',
        'priority'    => 6,
    ) );

    $wp_customize->add_setting( 'mec_theme_show_contact_social', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'mec_theme_show_contact_social', array(
        'label'       => __( 'Show Social Icons (Tablet & Mobile)', 'mec_theme' ),
        'description' => __( 'Applies at 768px wide and below only. Desktop always shows social icons.', 'mec_theme' ),
        'section'     => 'mec_theme_contact_social_section',
        'type'        => 'checkbox',
        'priority'    => 7,
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
        'default'           => '',
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
        'default'           => '',
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
        'default'           => '',
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

    $wp_customize->add_setting( 'mec_theme_contact_phone_hover_color', array(
        'default'           => '#0274be',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_contact_phone_hover_color', array(
        'label'    => __( 'Phone Numbers Hover Color', 'mec_theme' ),
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

    $wp_customize->add_setting( 'mec_theme_contact_email_hover_color', array(
        'default'           => '#0274be',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mec_theme_contact_email_hover_color', array(
        'label'    => __( 'Email Address Hover Color', 'mec_theme' ),
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
        updateSocial( 'mec_theme_facebook_url', '.mec-network-facebook' );
        updateSocial( 'mec_theme_twitter_url', '.mec-network-twitter' );
        updateSocial( 'mec_theme_instagram_url', '.mec-network-instagram' );
        updateSocial( 'mec_theme_linkedin_url', '.mec-network-linkedin' );
        updateSocial( 'mec_theme_youtube_url', '.mec-network-youtube' );

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

        // Live preview for phone/email hover colors. :hover can't be set
        // via jQuery .css(), so this maintains its own <style> tag and
        // rewrites it on change -- same pattern already used for tagline
        // alignment and description-hiding preview elsewhere in the theme.
        function updateContactHoverPreview() {
            var phoneHover = wp.customize( 'mec_theme_contact_phone_hover_color' ).get();
            var emailHover = wp.customize( 'mec_theme_contact_email_hover_color' ).get();
            var styleId = 'mec-theme-contact-hover-preview';
            var $style = $( '#' + styleId );
            if ( $style.length === 0 ) {
                $style = $( '<style id="' + styleId + '"></style>' ).appendTo( 'head' );
            }
            var css = '';
            if ( phoneHover ) {
                css += '.header-contact-column .contact-phone:hover { color: ' + phoneHover + '; }';
            }
            if ( emailHover ) {
                css += '.header-contact-column .contact-email a:hover { color: ' + emailHover + '; }';
            }
            $style.html( css );
        }
        wp.customize( 'mec_theme_contact_phone_hover_color', function( value ) {
            value.bind( updateContactHoverPreview );
        } );
        wp.customize( 'mec_theme_contact_email_hover_color', function( value ) {
            value.bind( updateContactHoverPreview );
        } );
        updateContactHoverPreview();

        // Live preview for hiding contact column, and for the individual
        // phone/email/social block toggles (all tablet+mobile-only, <=768px)
        function updateContactVisibility() {
            var hideTablet = wp.customize( 'mec_theme_hide_contact_tablet' ).get();
            var hideMobile = wp.customize( 'mec_theme_hide_contact_mobile' ).get();
            var showPhones = wp.customize( 'mec_theme_show_contact_phones' ).get();
            var showEmail = wp.customize( 'mec_theme_show_contact_email' ).get();
            var showSocial = wp.customize( 'mec_theme_show_contact_social' ).get();
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
            if ( ! showPhones ) {
                css += '@media (max-width: 768px) { .contact-phones-row { display: none !important; } }';
            }
            if ( ! showEmail ) {
                css += '@media (max-width: 768px) { .header-contact-column .contact-email { display: none !important; } }';
            }
            if ( ! showSocial ) {
                css += '@media (max-width: 768px) { .header-contact-column .contact-social { display: none !important; } }';
            }
            $style.html(css);
        }
        wp.customize( 'mec_theme_hide_contact_tablet', function( value ) {
            value.bind( updateContactVisibility );
        } );
        wp.customize( 'mec_theme_hide_contact_mobile', function( value ) {
            value.bind( updateContactVisibility );
        } );
        wp.customize( 'mec_theme_show_contact_phones', function( value ) {
            value.bind( updateContactVisibility );
        } );
        wp.customize( 'mec_theme_show_contact_email', function( value ) {
            value.bind( updateContactVisibility );
        } );
        wp.customize( 'mec_theme_show_contact_social', function( value ) {
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

/*
 * Note: CSS output for these social icon settings is handled by
 * mec_theme_get_root_variables_css() in inc/customizer-css.php, which
 * generates the properly-namespaced --mec-social-icon-* variables that
 * style.css's .social-icon rules actually consume. A duplicate
 * mec_theme_social_icon_css() function used to run on wp_head here,
 * outputting a second, unprefixed variable set (--social-icon-size, etc.)
 * that style.css never referenced -- pure dead weight on every page load.
 * Removed in 1.7.30; the settings above are unaffected and continue to
 * work exactly as before via the customizer-css.php path.
 */
