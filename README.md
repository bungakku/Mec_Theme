=== MEC Theme ===
Contributors: Biswajit
Tags: blog, custom-logo, custom-menu, featured-images, threaded-comments, translation-ready, two-columns, right-sidebar, responsive-layout, sticky-header, grid-layout, block-editor-support, accessibility-ready
Requires at least: 5.0
Tested up to: 6.6
Stable tag: 1.7.11
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

= 1.7.11 =
* Fixed: with "Enable Sticky Header" turned on (Customize > Layout Settings > Header), `.site-header` was given `position: sticky` with no explicit `width`. On mobile, this could leave the header pinned to whatever width was correct at the exact moment it first became "stuck" during a scroll -- if a vertical scrollbar appeared or disappeared around that same moment (common right after page load, once content below the fold finishes rendering and changes total page height), the header's stuck width didn't always get recalculated afterward. This showed up as a vertical gap along one edge of the page that was present from first scroll, identical across browsers, but disappeared on pinch-zoom (forces a full layout recalculation) or page reload (restarts before the sticky state has triggered) -- exactly the symptoms reported and reproduced in this troubleshooting session. Added explicit `left: 0; width: 100%;` to the sticky header rule so its width is tied directly to the viewport on every layout pass instead of being implicitly inherited once and potentially left stale.
* No change for sites with "Enable Sticky Header" turned off; this only touches the CSS generated when that setting is enabled.

= 1.7.10 =
* Fixed: the v1.7.9 release zip had an extra nested folder (assets/, inc/, etc. were one level deeper than every prior release), which would have produced an invalid theme structure if extracted directly into wp-content/themes/. This release restores the flat structure used by all releases through 1.7.8.
* Fixed: several `inc/` files carried a comment noting which version's "file-organization pass" extracted them from functions.php/customizer.php. That reorganization happened once, in 1.7.1 -- the comment was being incorrectly rewritten to the current version number on every release since, falsely implying a reorganization happened every time. Corrected to state the actual version (1.7.1) permanently.
* Housekeeping: this release contains no template, style, or Customizer behavior changes -- it exists solely to ship a correctly-packaged, consistently-versioned copy of 1.7.9's fixes after a packaging error in that release's zip.

= 1.7.9 =
* Fixed: images inserted into post/page content (via the editor) had no width constraint, so an image uploaded at its native resolution (e.g. 1600px wide) would render at full size regardless of viewport. On mobile and tablet this pushed .entry-content, .primary, .content-area, and .container wider than the screen -- body's existing `overflow-x: hidden` only hid the resulting scrollbar, it didn't stop the layout itself from being oversized, which is what made the page edges look uncontained/"not fixed" on small screens. Added a global `max-width: 100%; height: auto;` rule for img/video/embed/object, scoped narrowly enough that existing more specific image rules (.post-thumbnail img, .author-info img, etc.) still override it as before.
* Fixed: embedded videos (YouTube/Vimeo embeds pasted into content) had no CSS making the iframe itself scale down. `add_theme_support('responsive-embeds')` wraps embeds in a ratio container, but still needs this to be effective.
* Fixed: a wide table in post content (more columns than fit a phone screen) would force the same kind of horizontal overflow as the image issue above. Tables now scroll horizontally within their own bounds instead of widening the page.
* No Customizer settings, template logic, or JS were touched; this is a style.css-only fix.

= 1.7.8 =
* Fixed: the update checker used GitHub's `/releases/latest` endpoint, which picks "latest" by the release's underlying commit/publish order, not by comparing version numbers. Because v1.7.4 was published after v1.7.6 in this repository's history, `/releases/latest` was pointing at v1.7.4 -- meaning a site on an older version could be told v1.7.4 was the newest available, skipping past v1.7.6 and v1.7.7 entirely. The checker now fetches the recent release list and selects whichever one has the highest version number by semantic comparison, so it gives a correct result regardless of GitHub's ordering or "latest" label. Draft releases, pre-releases, and tags that aren't well-formed version numbers are now explicitly skipped as candidates.
* Removed: the cached release data included a `body` field (the release notes) that was sanitized but never actually displayed anywhere -- dead weight, same as a couple of earlier cleanups in this theme. Removed rather than wiring up an unused feature.
* No template, style, or Customizer behaviour was touched; this only affects how inc/github-updater.php decides which GitHub release is newest.

= 1.7.7 =
* Added: GitHub-based update checker (inc/github-updater.php). Since this theme isn't distributed via WordPress.org, there was previously no way for a site to know when a new version was available. This hooks into WordPress's native theme-update system, checking https://github.com/bungakku/Mec_Theme/releases for new tags -- sites running the theme now get the normal "Update available" notice and a working "Update now" button, exactly like a WordPress.org theme update. Checks are cached for 12 hours to stay well under GitHub's API rate limit. This is purely additive: the only change to any existing file is one new `require_once` line in functions.php; no template, style, or Customizer behaviour was touched.

= 1.7.6 =
* Removed: the unused "Social Menu" nav menu location (`register_nav_menus`). The theme already has a dedicated social-icon system in Customizer > Contact & Social with per-platform URL fields, proper icon styling, and accessible labels — a generic menu location for the same purpose was dead weight that could be assigned in the admin but never rendered anywhere.
* Fixed: "Mobile Close Button Hover Color" was a real Customizer setting with no effect — the hover state was hardcoded to the site's primary color variable instead. Wired it up via a dedicated `--mec-mobile-close-hover-color` CSS variable, matching the pattern already used for its sibling "Mobile Close Button (X) Color" setting.
* The .pot file was regenerated again to drop the now-removed "Social Menu" string; still 1:1 with source, no missing or orphaned entries.

= 1.7.5 =
* Fixed: languages/mec_theme.pot was missing 49 translatable strings, mostly the Tablet/Mobile Menu Colors panels added in 1.7.3, plus a handful of older strings (e.g. search form labels, 404/no-results text) that appear to have been missed in earlier exports. Regenerated the file from scratch against the current source; it now covers all 255 translatable strings in the theme, each with accurate file:line references.

= 1.7.4 =
* Fixed: Tablet/Mobile Dropdown Hover Background defaulted to `#f0f0f0`, which gave the existing hover-text blue (`#0274be`) a 4.34:1 contrast ratio against it — just under the WCAG AA 4.5:1 threshold for normal text. Changed the default to `#f8f9fa` (4.69:1, passing), matching the hover-background default already used for the desktop dropdown and general menu hover elsewhere in the theme. Sites that already saved a custom value for these two settings are unaffected; this only changes the out-of-the-box default.

= 1.7.3 =
* Added: Separate Tablet Menu Colors (481px-768px) and Mobile Menu Colors (480px and below) sections in Customizer > Colors. Previously a single "Mobile Menu Colors" section covered both ranges together with no way to set them differently, and dropdown/submenu colors weren't customizable at all below desktop width (the submenu background and divider color were hardcoded). Each range now has its own background, text, hover background, hover text for both the top-level menu and its dropdown/submenu, plus a dropdown divider color. The hamburger button and mobile close (X) button remain shared across both ranges, since they're one UI element rather than two.

= 1.7.2 =
* Removed: `mec_theme_validate_hex_color()` — dead code, never called anywhere in the theme (`mec_theme_get_color_var()` already does the equivalent job via `sanitize_hex_color()`).

= 1.7.1 =
* Improved: Reorganized theme files for maintainability. functions.php and inc/customizer.php were each doing several unrelated jobs in one large file; split into focused files with no change in behavior:
  - inc/class-recent-posts-widget.php — the Recent Posts widget class.
  - inc/customizer-css.php — all Customizer-driven CSS generation + caching.
  - inc/customizer-sanitizers.php — every Customizer sanitize_callback/validator in one place, for easy auditing.
  - inc/customizer/layout-panel.php, typography-panel.php, colors-panel.php, blog-panel.php, contact-social-panel.php — one file per Customizer panel.
  - inc/customizer.php is now a short file that requires the panel files and registers them; functions.php is now limited to theme setup, widget/asset registration, and a handful of small template hooks.
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