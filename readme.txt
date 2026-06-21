=== MEC Theme ===
Author: Biswajit
Tags: blog, custom-logo, custom-menu, featured-images, threaded-comments, translation-ready, two-columns, right-sidebar, responsive-layout, sticky-header, grid-layout, block-editor-support, accessibility-ready
Requires at least: 5.0
Tested up to: 6.6
Stable tag: 1.7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A lightweight, fully responsive WordPress theme for educational institutions, blogs, and business websites. Optimized for mobile with extensive customizer options.

== Description ==

MEC Theme is a modern, flexible WordPress theme designed for Mount Everest College. It offers a clean design, mobile-first approach, and a wealth of customization settings without needing to touch code.

== Key Features ==

* Responsive Design – Looks great on all devices (mobile, tablet, desktop).
* Customizer Powered – Change colors, fonts, layouts, and more in real time.
* Multiple Blog Layouts – Classic, grid (2/3/4 columns), and list views.
* Sticky Header – Keep your header always visible.
* Custom Logo & Site Identity – Upload your logo and control its position.
* Advanced Typography – Set font sizes per device (desktop/tablet/mobile).
* Footer Widgets – 1–4 columns, horizontal or vertical arrangement.
* Author Bio & Related Posts – Automatically displayed on single posts.
* Translation Ready – Fully localizable with a complete .pot file.
* SEO Friendly – Clean code and fast loading.
* Mobile-optimised Search – In-menu search bar with relative positioning and compact styling.
* Accessibility Ready – ARIA attributes, keyboard navigation, focus management, skip-to-content link, accessible comment counts.
* Custom Recent Posts Widget – Display recent posts with thumbnail, excerpt, and "Read More" link.
* Block Editor Support – Custom colour palette and font sizes for an enhanced editing experience.
* CSS Custom Properties – Dynamic styling with minimal generated CSS for better performance.

== Installation ==

1. Upload the `mec_theme` folder to the `/wp-content/themes/` directory, or install via WordPress admin.
2. Activate the theme through the 'Appearance > Themes' menu.
3. Go to Appearance > Customize to configure your site.

== Frequently Asked Questions ==

= How do I change the menu hover color? =
Navigate to Appearance > Customize > Menu Settings and use the "Main Menu Hover Color" option.

= Can I hide the site description on mobile? =
Yes, under Customize > Layout Settings > Header, you'll find checkboxes to hide the description on tablet and mobile.

= How do I create a grid layout for blog posts? =
Go to Customize > Blog Settings > Blog Layout and select "Grid Layout". Then choose the number of columns.

= How do I use the custom recent posts widget? =
Go to Appearance > Widgets and add the widget titled "MEC Recent Posts (with excerpt)". You can show/hide thumbnail, excerpt, and read more link.

= Can I align the tagline differently? =
Yes – go to Customize > Layout Settings > Header and choose Tagline Alignment (left, center, or right). Default is centre for backward compatibility.

= Is the theme accessible? =
Yes, the theme includes aria-expanded states for mobile menu and submenu toggles, focus management when opening/closing the menu, a skip-to-content link, and screen-reader-friendly comment counts.

== Changelog ==

= 1.7.0 =
* Fixed: Tagline Alignment setting had `postMessage` transport but no matching live-preview JS, so changing it in the Customizer did nothing until save/reload. Added a live-preview binding that updates the `--mec-tagline-align` CSS variable in real time, with the same left/center/right whitelist used server-side.

= 1.6.9 =
* Security: Fixed CSS/HTML injection in Body/Heading Font Family Customizer settings — values are now restricted to a strict whitelist (matching the dropdown choices) instead of generic text sanitization, since these values are written directly into an inline `<style>` block.
* Security: Added a character-whitelist check in the font-family CSS formatter as a defense-in-depth backstop.
* Security: Hardened search form screen-reader label output with `esc_html_x()`; made the search button's `aria-label` translatable and properly escaped.

= 1.6.8 =
* Added: Custom recent posts widget with thumbnail, excerpt, and "Read More" link.
* Added: Tagline alignment option in Customizer (left/center/right).
* Added: Block editor colour palette (primary, secondary, dark grey, light grey, white).
* Added: Block editor font sizes support.
* Added: CSS custom properties for all theme colours and layout values – dramatically reduces generated CSS size.
* Improved: Comment count accessibility – now includes screen-reader text.
* Improved: Hamburger button margin on mobile – fixed issue where button touched right edge when sidebar widgets were present.
* Improved: Mobile close button now has a descriptive aria-label ("Close menu").
* Improved: Refactored customiser CSS generator into smaller, maintainable functions.
* Changed: Replaced `date()` with `date_i18n()` in default copyright text (respects WordPress timezone).
* Changed: Removed forced `text-align: center` from `.site-tagline` – now inherits from new Customizer setting.
* Updated: Editor styles to match theme colour palette.
* Version: Bumped all version headers to 1.6.8.

= 1.6.7 =
* Fixed: Desktop displaying mobile menu panel – panel now hidden on screens >768px.
* Fixed: Invalid HTML structure – mobile menu now uses a valid `.mobile-menu-panel` container.
* Added: aria-expanded attribute toggling for submenu parent links (accessibility).
* Added: Focus management – when mobile panel opens, focus moves to close button; when closed, focus returns to hamburger button.
* Improved: Search form placeholder text is now translatable (esc_attr_e).
* Performance: Customizer CSS is cached via transient, regenerated only when settings change.
* Security: All files include ABSPATH checks; proper escaping throughout.

= 1.6.6 =
* Added: Hamburger menu color controls in Customizer (background, icon color, hover states)
* Added: Mobile close button (X) color controls
* Added: Phone and email color controls in Customizer
* Changed: Mobile search input from rounded corners to rectangular for better UI consistency
* Security: Added ABSPATH protection to all files
* Security: Fixed unescaped search query output in searchform.php
* Improved: Layout width validation in Customizer (content + sidebar ≤ 100%)

= 1.6.5 =
* Security: Added ABSPATH checks to all root PHP templates.
* Security: Fixed unescaped search query output in search.php (XSS prevention).
* Corrected single.php template.
* Version consistency: Unified all version numbers to 1.6.5.

= 1.6.4 =
* Mobile menu gap fix – changed selector to prevent extra padding on submenus.

= 1.6.3 =
* Mobile search bar: changed from fixed to relative positioning; now uses 95% width and compact input styling.
* Backward compatibility: Added wp_body_open() fallback for WordPress versions < 5.2.

= 1.6.1 =
* Added separate hover color control for main menu.
* Improved mobile menu behaviour.
* Updated translation files.

= 1.6.0 =
* Initial release.

== Credits ==

Developed by Biswajit – https://biswazit.in
Icons are inline SVGs created by the author.
No external libraries or assets are used.