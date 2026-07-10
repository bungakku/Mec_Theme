<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Customizer-driven CSS generation and caching.
 *
 * Extracted from functions.php during the 1.7.1 file-organization pass.
 * No behavior changed: every function here is identical to its previous
 * version, just grouped together since they form one coherent job
 * (turn theme_mods into the inline <style> block added in functions.php
 * via mec_theme_scripts() -> wp_add_inline_style()).
 *
 * @package MEC_Theme
 */

function mec_theme_get_color_var( $mod, $default ) {
    $color = get_theme_mod( $mod, $default );
    $sanitized = sanitize_hex_color( $color );
    return $sanitized ?: $default;
}

/**
 * Given a hex color, return a contrasting text color (near-black or
 * near-white) suitable for text placed on top of it.
 *
 * Uses the standard relative-luminance formula (the same weighting WCAG
 * contrast calculations use: 0.299/0.587/0.114 for R/G/B) rather than a
 * naive average of the three channels, since human eyes are far more
 * sensitive to green than red or blue -- a naive average misjudges some
 * colors (e.g. a saturated blue reads as "dark" to this formula but a
 * naive RGB average can call it borderline).
 *
 * This lets a single Customizer color choice (e.g. Footer Background)
 * automatically produce a readable, contrasting color for dependent text
 * (e.g. the footer credit link) without the site owner needing to pick a
 * second, separate color and keep the two in sync by hand every time the
 * background changes.
 *
 * @param string $hex      A #rrggbb hex color (already sanitized by the caller).
 * @param string $dark     Color to return for light backgrounds. Default near-black.
 * @param string $light    Color to return for dark backgrounds. Default near-white.
 * @return string
 */
function mec_theme_get_contrast_color( $hex, $dark = '#1a1a1a', $light = '#f5f5f5' ) {
    $hex = ltrim( (string) $hex, '#' );
    if ( strlen( $hex ) !== 6 || ! ctype_xdigit( $hex ) ) {
        return $dark; // Malformed input: fall back to dark text, the safer default against this theme's typically light backgrounds.
    }
    $r = hexdec( substr( $hex, 0, 2 ) );
    $g = hexdec( substr( $hex, 2, 2 ) );
    $b = hexdec( substr( $hex, 4, 2 ) );
    $luminance = ( 0.299 * $r + 0.587 * $g + 0.114 * $b ) / 255;
    // Threshold of 0.55 (rather than the more common 0.5) is deliberately
    // biased slightly toward returning the dark color, since mid-tone
    // backgrounds tend to pair more reliably with dark text in practice.
    return ( $luminance > 0.55 ) ? $dark : $light;
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
    $css .= '--mec-footer-credit-color: ' . mec_theme_get_contrast_color( $footer_bg ) . ';';
    
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
    
    $menu_hover_underline = mec_theme_get_color_var( 'mec_theme_menu_hover_underline_color', '#0274be' );
    $css .= '--mec-menu-hover-underline-color: ' . $menu_hover_underline . ';';
    
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
    
    // Mobile close hover colour
    $close_hover_color = mec_theme_get_color_var( 'mec_theme_mobile_close_hover_color', '#0274be' );
    $css .= '--mec-mobile-close-hover-color: ' . $close_hover_color . ';';
    
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
        // width: 100% (rather than relying on the implicit block width a
        // sticky element would otherwise keep) forces the browser to
        // recompute the header's width against the current viewport on
        // every layout pass, instead of potentially keeping whatever width
        // was correct at the exact moment the header first became "stuck"
        // during a scroll. Without this, some mobile browser engines can
        // leave the sticky header pinned to a width that was correct before
        // a vertical scrollbar appeared (or disappeared) later in the page
        // load -- which looks like a persistent gap on one side until the
        // user pinch-zooms or reloads and the layout is recalculated fresh.
        $css .= '.site-header { position: sticky; top: 0; left: 0; width: 100%; z-index: 100; }';
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
    
    // Contact phone/email text size -- tablet + mobile ONLY (no desktop
    // setting exists here deliberately). Desktop keeps its fixed 0.9rem
    // from .header-contact-column's base rule in style.css, unaffected by
    // this or the mobile block below.
    $contact_text_size_tablet = get_theme_mod( 'mec_theme_contact_text_size_tablet', '0.85' );
    $css .= '@media (min-width: 481px) and (max-width: 768px) { .header-contact-column .contact-phone, .header-contact-column .contact-email { font-size: ' . floatval( $contact_text_size_tablet ) . 'rem; } }';
    
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
    
    $contact_text_size_mobile = get_theme_mod( 'mec_theme_contact_text_size_mobile', '0.8' );
    $css .= '@media (max-width: 480px) { .header-contact-column .contact-phone, .header-contact-column .contact-email { font-size: ' . floatval( $contact_text_size_mobile ) . 'rem; } }';
    
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
 * Generate tablet menu colours CSS (481px - 768px): menu items + dropdown/submenu.
 */
function mec_theme_get_tablet_menu_colors_css() {
    $css = '@media (min-width: 481px) and (max-width: 768px) {';

    // Top-level menu items
    $menu_bg = get_theme_mod( 'mec_theme_tablet_menu_bg', '#ffffff' );
    if ( $menu_bg && preg_match( '/^#[a-f0-9]{6}$/i', $menu_bg ) ) {
        $css .= '.main-navigation ul { background-color: ' . esc_attr( $menu_bg ) . '; }';
    }

    $menu_text = get_theme_mod( 'mec_theme_tablet_menu_text', '#3a3a3a' );
    if ( $menu_text && preg_match( '/^#[a-f0-9]{6}$/i', $menu_text ) ) {
        $css .= '.main-navigation a { color: ' . esc_attr( $menu_text ) . '; }';
    }

    $menu_hover_bg = get_theme_mod( 'mec_theme_tablet_menu_hover_bg', '#f8f9fa' );
    $menu_hover_text = get_theme_mod( 'mec_theme_tablet_menu_hover_text', '#0274be' );
    if ( $menu_hover_bg || $menu_hover_text ) {
        $css .= '.main-navigation a:hover {';
        if ( $menu_hover_bg && preg_match( '/^#[a-f0-9]{6}$/i', $menu_hover_bg ) ) {
            $css .= 'background-color: ' . esc_attr( $menu_hover_bg ) . ';';
        }
        if ( $menu_hover_text && preg_match( '/^#[a-f0-9]{6}$/i', $menu_hover_text ) ) {
            $css .= 'color: ' . esc_attr( $menu_hover_text ) . ';';
        }
        $css .= '}';
    }

    // Dropdown / submenu items (more specific selectors so they can differ
    // from the top-level menu colours above)
    $dropdown_bg = get_theme_mod( 'mec_theme_tablet_dropdown_bg', '#f9f9f9' );
    if ( $dropdown_bg && preg_match( '/^#[a-f0-9]{6}$/i', $dropdown_bg ) ) {
        $css .= '.main-navigation ul ul { background-color: ' . esc_attr( $dropdown_bg ) . '; }';
    }

    $dropdown_text = get_theme_mod( 'mec_theme_tablet_dropdown_text', '#3a3a3a' );
    if ( $dropdown_text && preg_match( '/^#[a-f0-9]{6}$/i', $dropdown_text ) ) {
        $css .= '.main-navigation ul ul a { color: ' . esc_attr( $dropdown_text ) . '; }';
    }

    $dropdown_hover_bg = get_theme_mod( 'mec_theme_tablet_dropdown_hover_bg', '#f8f9fa' );
    $dropdown_hover_text = get_theme_mod( 'mec_theme_tablet_dropdown_hover_text', '#0274be' );
    if ( $dropdown_hover_bg || $dropdown_hover_text ) {
        $css .= '.main-navigation ul ul a:hover {';
        if ( $dropdown_hover_bg && preg_match( '/^#[a-f0-9]{6}$/i', $dropdown_hover_bg ) ) {
            $css .= 'background-color: ' . esc_attr( $dropdown_hover_bg ) . ';';
        }
        if ( $dropdown_hover_text && preg_match( '/^#[a-f0-9]{6}$/i', $dropdown_hover_text ) ) {
            $css .= 'color: ' . esc_attr( $dropdown_hover_text ) . ';';
        }
        $css .= '}';
    }

    $dropdown_border = get_theme_mod( 'mec_theme_tablet_dropdown_border', '#e0e0e0' );
    if ( $dropdown_border && preg_match( '/^#[a-f0-9]{6}$/i', $dropdown_border ) ) {
        $css .= '.main-navigation ul ul li { border-bottom-color: ' . esc_attr( $dropdown_border ) . '; }';
    }

    $css .= '}'; // close @media (min-width: 481px) and (max-width: 768px)

    return $css;
}

/**
 * Generate mobile menu colours CSS (480px and below): menu items + dropdown/submenu,
 * plus the hamburger button and mobile close (X) button, which are shared
 * across tablet and mobile rather than split per breakpoint.
 */
function mec_theme_get_mobile_menu_colors_css() {
    $css = '@media (max-width: 480px) {';

    // Top-level menu items
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

    // Dropdown / submenu items (more specific selectors so they can differ
    // from the top-level menu colours above)
    $mobile_dropdown_bg = get_theme_mod( 'mec_theme_mobile_dropdown_bg', '#f9f9f9' );
    if ( $mobile_dropdown_bg && preg_match( '/^#[a-f0-9]{6}$/i', $mobile_dropdown_bg ) ) {
        $css .= '.main-navigation ul ul { background-color: ' . esc_attr( $mobile_dropdown_bg ) . '; }';
    }

    $mobile_dropdown_text = get_theme_mod( 'mec_theme_mobile_dropdown_text', '#3a3a3a' );
    if ( $mobile_dropdown_text && preg_match( '/^#[a-f0-9]{6}$/i', $mobile_dropdown_text ) ) {
        $css .= '.main-navigation ul ul a { color: ' . esc_attr( $mobile_dropdown_text ) . '; }';
    }

    $mobile_dropdown_hover_bg = get_theme_mod( 'mec_theme_mobile_dropdown_hover_bg', '#f8f9fa' );
    $mobile_dropdown_hover_text = get_theme_mod( 'mec_theme_mobile_dropdown_hover_text', '#0274be' );
    if ( $mobile_dropdown_hover_bg || $mobile_dropdown_hover_text ) {
        $css .= '.main-navigation ul ul a:hover {';
        if ( $mobile_dropdown_hover_bg && preg_match( '/^#[a-f0-9]{6}$/i', $mobile_dropdown_hover_bg ) ) {
            $css .= 'background-color: ' . esc_attr( $mobile_dropdown_hover_bg ) . ';';
        }
        if ( $mobile_dropdown_hover_text && preg_match( '/^#[a-f0-9]{6}$/i', $mobile_dropdown_hover_text ) ) {
            $css .= 'color: ' . esc_attr( $mobile_dropdown_hover_text ) . ';';
        }
        $css .= '}';
    }

    $mobile_dropdown_border = get_theme_mod( 'mec_theme_mobile_dropdown_border', '#e0e0e0' );
    if ( $mobile_dropdown_border && preg_match( '/^#[a-f0-9]{6}$/i', $mobile_dropdown_border ) ) {
        $css .= '.main-navigation ul ul li { border-bottom-color: ' . esc_attr( $mobile_dropdown_border ) . '; }';
    }

    $css .= '}'; // close @media (max-width: 480px)

    // Hamburger button and mobile close (X) button: shared across tablet and
    // mobile, so this block uses the wider 768px breakpoint rather than 480px.
    $css .= '@media (max-width: 768px) {';

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

    // Mobile close (X) button colour (both regular and hover) is applied via
    // the --mec-mobile-close-color / --mec-mobile-close-hover-color CSS
    // variables in mec_theme_get_root_variables_css(), not here.

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

    // Individual phone/email/social block toggles -- tablet + mobile only
    // (<=768px combined). Desktop is never affected: these blocks always
    // render in header.php's markup; this CSS is the only thing that ever
    // hides them, and only within this single media query.
    if ( ! get_theme_mod( 'mec_theme_show_contact_phones', true ) ) {
        $css .= '@media (max-width: 768px) { .contact-phones-row { display: none !important; } }';
    }
    if ( ! get_theme_mod( 'mec_theme_show_contact_email', true ) ) {
        $css .= '@media (max-width: 768px) { .header-contact-column .contact-email { display: none !important; } }';
    }
    if ( ! get_theme_mod( 'mec_theme_show_contact_social', true ) ) {
        $css .= '@media (max-width: 768px) { .header-contact-column .contact-social { display: none !important; } }';
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
    
    // Tablet menu colours (481px - 768px)
    $css .= mec_theme_get_tablet_menu_colors_css();
    
    // Mobile menu colours and additional overrides
    $css .= mec_theme_get_mobile_menu_colors_css();
    
    // Contact phone/email colours (specific selectors) + hover states
    $phone_color = get_theme_mod( 'mec_theme_contact_phone_color', '#333333' );
    if ( $phone_color && preg_match( '/^#[a-f0-9]{6}$/i', $phone_color ) ) {
        $css .= '.header-contact-column .contact-phone { color: ' . esc_attr( $phone_color ) . '; }';
    }
    $phone_hover_color = get_theme_mod( 'mec_theme_contact_phone_hover_color', '#0274be' );
    if ( $phone_hover_color && preg_match( '/^#[a-f0-9]{6}$/i', $phone_hover_color ) ) {
        $css .= '.header-contact-column .contact-phone { transition: color 0.3s ease; }';
        $css .= '.header-contact-column .contact-phone:hover { color: ' . esc_attr( $phone_hover_color ) . '; }';
    }
    $email_color = get_theme_mod( 'mec_theme_contact_email_color', '#333333' );
    if ( $email_color && preg_match( '/^#[a-f0-9]{6}$/i', $email_color ) ) {
        $css .= '.header-contact-column .contact-email a { color: ' . esc_attr( $email_color ) . '; }';
    }
    $email_hover_color = get_theme_mod( 'mec_theme_contact_email_hover_color', '#0274be' );
    if ( $email_hover_color && preg_match( '/^#[a-f0-9]{6}$/i', $email_hover_color ) ) {
        $css .= '.header-contact-column .contact-email a { transition: color 0.3s ease; }';
        $css .= '.header-contact-column .contact-email a:hover { color: ' . esc_attr( $email_hover_color ) . '; }';
    }
    
    // Site title colour (using variable but also direct for older browsers)
    $site_title_color = mec_theme_get_color_var( 'mec_theme_site_title_color', '#333333' );
    $css .= '.site-title a { color: ' . $site_title_color . '; }';
    
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
