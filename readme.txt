=== MEC Theme ===
Contributors: Biswajit Thokchom
Tags: blog, custom-logo, custom-menu, featured-images, threaded-comments, translation-ready, two-columns, right-sidebar, responsive-layout, sticky-header, grid-layout, block-editor-support, accessibility-ready
Requires at least: 5.0
Tested up to: 6.6
Stable tag: 1.7.40
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Author URl:  https://github.com/bungakku

A lightweight, fully responsive WordPress theme for educational institutions, blogs, and business websites. Optimized for mobile with extensive customizer options.

== Description ==

MEC Theme is a modern, flexible WordPress theme initially designed for Mount Everest College. It offers a clean design, mobile-first approach, and a wealth of customization settings without needing to touch code.

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

= 1.7.40 =
* Added: a diagnostic-only build fingerprint -- a short hash of the footer's "Theme by Biswajit" credit markup plus the current theme version, output as a hidden HTML comment (`<!-- mec-theme-build: ... -->`) near the credit line. Purely informational: it does not restrict, hide, alter, or gate any theme functionality, and nothing in the theme reads it back. It exists solely so the theme author can verify, via "View Source" or a plain HTTP fetch, that a live deployment is running the exact, unmodified credit for a given version -- without needing admin access. The hash is computed from whatever the credit markup actually renders, so editing or removing the credit simply changes the emitted value; there's no hidden check being "passed" or "failed."
* Added: CHANGELOG.md at the theme root -- a Keep a Changelog-formatted, GitHub-friendly companion to this file's history, covering every release from 1.6.0 through 1.7.40. readme.txt remains the authoritative WordPress-facing changelog; CHANGELOG.md is generated from it for repo-browsing convenience and will be kept in sync on every future release.

= 1.7.39 =
* Fixed: title/logo and the phone/email/social block visibly aligned differently on tablet (481-768px), confirmed via screenshot -- the logo+title+tagline group sat flush-left while phone/email centered normally. Root cause: a legacy rule forces `.site-branding { width: 100% !important; }` at this breakpoint (originally paired with a `.header-content.title-align-tablet-center` centering rule that has never actually matched anything, since no element in header.php carries a `.header-content` class), leaving `.site-branding`'s content with no centering behavior of its own once it became full-width. `.header-contact-column` (fixed in 1.7.38) already correctly shrink-wraps and centers via `.header-top-row`'s `align-items: center`; `.site-branding` did not. Added `justify-content: center` to `.site-branding` at <=768px so the logo+text group now centers on the same axis as the contact column, at both tablet and mobile widths.
* Note: because the logo still sits beside the title (not stacked above it) at this breakpoint, the tagline's own text can still sit slightly off the exact same center point as phone/email, by roughly half the logo's width -- this is a much smaller, secondary effect than the flush-left/centered mismatch fixed here. Setting Logo Position (Tablet/Mobile) to "Above Site Title" in Customize > Layout Settings > Header removes this residual offset entirely, since the logo no longer sits beside the text.

= 1.7.38 =
* Fixed: on tablet/mobile (<=768px), phone numbers, email, and social icons were centered against the FULL header width (`.header-contact-column` had `width: 100%`), while the tagline and site description centered only within their own, narrower shrink-wrapped content width -- two different alignment behaviors that didn't visually match, even though both blocks sit in the same stacked column. Removed `width: 100%` from `.header-contact-column` so it now shrink-wraps and gets centered as a block by `.header-top-row`'s existing `align-items: center`, the exact same mechanism `.site-branding`/`.site-text` already use. The contact block now aligns with the site's actual content width instead of the full page, consistently with the tagline/description, across tablet and mobile (desktop's row layout was never affected either way).
* Improved: further tightened the tablet/mobile stacked-header spacing per follow-up request -- `.header-top-row`'s gap (between the branding block and the contact block) reduced from 8px to 4px, and `.header-contact-column`'s own internal gap (between phones/email/social) reduced from 8px to 4px at this breakpoint only. Desktop's 8px contact-column gap is untouched.

= 1.7.37 =
* Fixed: large gap between the main content and sidebar widgets once the layout stacks into a single column on tablet/mobile (<=768px). Root cause: `.content-area` uses flex `gap` (20px) to space `.primary` and `.secondary` apart -- but on blog listing pages (front page, index, archive, search), the last `<article>` in `.primary` also had its own `margin-bottom` (20px at this breakpoint), and flex `gap` adds space ON TOP OF a child's own margin rather than replacing it. The two combined into a 40px gap that looked like one oversized value. Added `.has-sidebar .primary > *:last-child { margin-bottom: 0; }` (mobile/tablet only) so the trailing element's own spacing no longer stacks with the container gap, and reduced `.content-area`'s gap itself from 20px to `var(--mec-space-sm)` (12px) for a tighter overall feel. Desktop (>768px) is unaffected either way.
* Fixed: same doubled-gap pattern in the header's contact info once it stacks (tablet/mobile): `.header-contact-column` already spaces phone numbers / email / social icons apart via its own flex `gap: 8px`, but 1.7.34's mobile CSS additionally set `margin-bottom` on `.contact-phones-row` and `.contact-email`, doubling that spacing. Removed the redundant margins so the parent's `gap: 8px` is the only thing controlling that spacing. Also reduced `.header-top-row`'s gap (between the site branding block and the contact column) from 20px to `var(--mec-space-xs)` (8px) at this breakpoint -- it was sized for a horizontal desktop gap and felt oversized once stacked vertically. Desktop is unaffected; both changes live inside the existing `@media (max-width: 768px)` block.
* Added: "Phone & Email Text Size - Tablet (rem)" and "Phone & Email Text Size - Mobile (rem)" controls (Customize > Contact & Social), each independently sizing phone number and email text at that breakpoint only. No desktop control was added on purpose -- desktop keeps its existing fixed size from `.header-contact-column` in style.css, completely unaffected by either new setting. Implemented via `mec_theme_get_responsive_css()` in `inc/customizer-css.php`, the same function that already handles every other per-breakpoint font size in this theme (body, site title, tagline, description, heading, menu).

= 1.7.36 =
* Changed: the three block-visibility toggles added in 1.7.35 ("Show Phone Numbers", "Show Email Address", "Show Social Icons") were global -- unchecking one removed that block from the page entirely, on desktop too. They are now scoped to tablet + mobile only (768px wide and below): desktop always shows all three blocks regardless of these settings, matching how the existing "Hide contact column on tablet/mobile" toggles already behave at the whole-column level. Labels and descriptions updated in the Customizer to make this scope explicit ("Show Phone Numbers (Tablet & Mobile)", etc.).
* No change to the 1.7.35 hover-color settings or CSS, or to any other Contact & Social field -- this only corrects the effective breakpoint scope of the three new visibility toggles.

= 1.7.35 =
* Added: independent Show/Hide toggles for the three Contact & Social blocks -- "Show Phone Numbers", "Show Email Address", "Show Social Icons" (Customize > Contact & Social). Each block can now be disabled on its own without affecting the others, separate from the existing tablet/mobile "hide contact column" toggles, which still hide the whole column at those breakpoints.
* Added: "Phone Numbers Hover Color" and "Email Address Hover Color" controls, next to their existing (non-hover) color settings. Phone numbers and the email link now have a smooth color transition on hover, live-previewed in the Customizer the same way the existing phone/email colors already were.
* No existing settings, classes, or markup were removed or renamed. `header.php`'s phone/email/social blocks are now each wrapped in their own visibility check (default: shown, matching current behavior on upgrade); `inc/customizer-css.php` gained two new hover CSS rules alongside the existing phone/email color rules.

= 1.7.34 =
* Added: separate side-by-side layout for Phone Number 1 and Phone Number 2 on tablet (481-768px) and mobile (<=480px) -- both now sit in a shared, centered, wrapping row (`.contact-phones-row`) above the email and social icons, instead of stacking fully vertically with everything else. Desktop (>768px) layout is unchanged.
* No new Customizer settings, sanitizers, or JS were added -- `header.php` now wraps the two existing phone `<div>`s in a new `.contact-phones-row` container, and `style.css`'s existing `@media (max-width: 768px)` block (already shared by tablet and mobile) gained the row styling. All existing classes (`.contact-phone`, `.contact-phone-1/2`, `.contact-email`, `.contact-social`) are untouched, so the live-preview JS in `inc/customizer/contact-social-panel.php` and the `mec_theme_hide_contact_tablet/mobile` toggles continue to work exactly as before.

= 1.7.33 =
* Improved: unified .container side padding to 10px on every breakpoint. Previously only phones (<=480px) got 10px while tablet (481-768px) and desktop kept the original 20px, so the reduction from 1.7.14 was inconsistent across devices. Confirmed feasible: no other rule (header rows, site branding, logo wrapper, etc.) depends on the old 20px gutter.
* Improved: reduced the gap above the mobile/tablet search bar in the off-canvas menu -- .mobile-search-form's top margin reduced from 15px to 6px, tightening the space between the close (X) button and the search field. Bottom spacing (before the menu list) is unchanged.
* Improved: reduced the gap between the main content and sidebar on desktop/tablet from 32px to 20px (.content-area now uses --mec-space-md instead of --mec-space-lg), matching the gap already used in the stacked mobile layout. The shared --mec-space-lg variable itself was left untouched, so article spacing, footer widgets, and other consumers of that variable are unaffected.

= 1.7.32 =
* Fixed: the "Desktop Menu Hover Underline Color" control (added in 1.7.31) had no visible effect -- no underline appeared on hover at all, in any color. Root cause: the CSS rule used a direct-child selector, `.main-navigation > ul > li > a:hover`, which never actually matched the real markup. The top-level menu `<ul id="primary-menu">` is not a direct child of `.main-navigation`; it sits inside `.mobile-menu-panel` (kept in the DOM on desktop too, just reset via CSS to blend in). Because the selector matched nothing, the entire rule -- including `text-decoration-color: var(--mec-menu-hover-underline-color)` -- was dead CSS, regardless of the color chosen in the Customizer. The setting, its sanitization, and the `--mec-menu-hover-underline-color` CSS variable pipeline (`inc/customizer/layout-panel.php`, `inc/customizer-css.php`) were all correct and did not need changes.
* Fixed the rule by targeting `.main-navigation #primary-menu > li > a:hover` (using the menu's own id, set via `wp_nav_menu()`'s `menu_id` in header.php) instead of relying on DOM depth. This is the only change; no other selector, setting, or file was touched.

= 1.7.31 =
* Added: "Desktop Menu Hover Underline Color" control (Layout Settings > Menu Settings, next to "Main Menu Hover Color"). The desktop top-level menu already underlines on hover (`.main-navigation > ul > li > a:hover`), but that underline had no color of its own -- it always rendered in whatever the hover text color happened to be, with no way to set it independently. New `--mec-menu-hover-underline-color` CSS variable, applied via `text-decoration-color`, controls just the underline; the hover text color setting is unaffected. Defaults to the same blue as the existing hover color, so sites see no visual change until this new option is explicitly customized.

= 1.7.30 =
* Fixed: the "Dropdown Menu Text Color" and "Dropdown Menu Hover Text Color" Customizer controls (Colors > Dropdown Menu Colors) had no effect on desktop dropdown/submenu links. Root cause: `inc/customizer-css.php` correctly generated the `--mec-dropdown-text` and `--mec-dropdown-hover-text` CSS variables from these settings, but `style.css` never applied them to `.main-navigation ul ul a` -- the selector only inherited the general menu text color and set a hover background, with no `color` declaration of its own at any state. Both variables are now wired in; tablet/mobile dropdown colors were unaffected by this (they're generated as direct per-breakpoint rules and already worked correctly).
* Removed: `mec_theme_social_icon_css()`, a duplicate CSS-output function in `inc/customizer/contact-social-panel.php` that ran on every front-end page load (`wp_head`, priority 20) and printed a second, unprefixed set of social-icon CSS variables (`--social-icon-size`, `--social-icon-bg`, etc.). `style.css`'s `.social-icon` rules only ever consumed the correctly-namespaced `--mec-social-icon-*` variables already generated by `inc/customizer-css.php` -- the removed function's output was never referenced anywhere and existed purely as dead weight. The six Social Icon settings themselves (size, colors, hover states) are untouched and continue to work exactly as before.
* Improved: `site_title_color` CSS output now goes through the same `mec_theme_get_color_var()` validation helper (re-checks `sanitize_hex_color()` before the value is written into the inline `<style>` block) that every other color setting in `inc/customizer-css.php` already uses, closing a minor inconsistency found during a full theme audit.
* Audit: full pass across all PHP/JS/CSS files for security (escaping, sanitization, nonces, capability checks), PHP errors/notices, broken hooks/filters/includes, and orphaned Customizer-to-CSS wiring. No other issues found -- existing nonce/capability checks, output escaping, `WP_Query` usage, and enqueue/dependency chains were all confirmed correct.

= 1.7.29 =
* Fixed: the three "default" social icon fields (Facebook, Twitter/X, Instagram) used a `'#'` default value with an extra `!== '#'` check, while LinkedIn and YouTube used an empty-string default with a plain `! empty()` check. If a theme mod was ever unset outside the normal Customizer save flow, the `'#'` default risked rendering a dead `href="#"` link before the guard caught it. All five fields now consistently default to `''` and are guarded with `! empty()`.
* Changed: social icon anchor classes renamed from `social-icon-facebook` / `social-icon-twitter` / `social-icon-instagram` / `social-icon-linkedin` / `social-icon-youtube` to `mec-network-facebook` / `mec-network-twitter` / `mec-network-instagram` / `mec-network-linkedin` / `mec-network-youtube`. The old class names matched generic-social-media patterns in some ad-blocker cosmetic filter lists (observed in Brave), causing icons to be hidden even when a URL was correctly set. The shared `.social-icon` wrapper class is unchanged.
* Note for sites with custom CSS: if you previously targeted `.social-icon-facebook` etc. in Customizer > Additional CSS or a child theme, update those selectors to the new `.mec-network-*` names.

= 1.7.28 =
* Fixed: 1.7.27's Title Settings (hide/align) had no effect on the front page. Cause: front-page.php renders through template-parts/content-blog.php, not content-page.php or content-post.php -- the two files 1.7.27 actually wired the feature into. content-blog.php now has the same logic.
* Fixed a second, related bug found while fixing the first: mec_theme_should_show_title() suppressed the title on EVERY post when the homepage setting (Settings > Reading) is "Your latest posts" -- is_front_page() is true for the whole request in that case too, not just when a static page is assigned as the front page, so every individual post in that blog-listing loop was incorrectly losing its title. Now also checks is_page(), so the suppression only applies to an actual static page used as the front page (e.g. one literally titled "FRONT PAGE"), and a blog-listing homepage shows each post's title normally, respecting that post's own per-post setting.
* If you tested 1.7.27's title settings on the front page and saw no effect (or saw every post's title disappear), this resolves both.

= 1.7.27 =
* Added: a proper "Title Settings" meta box on every Page and Post (in the editor sidebar) with two controls -- "Hide title on this page" and "Title alignment" (left/center/right). This replaces relying on a third-party title-hiding plugin: hiding the title here never leaves a gap behind, since the theme controls both the visibility and the spacing together rather than a plugin hiding content the layout still reserves room for. The front page continues to never show its title, regardless of this setting, same as 1.7.26.
* Fixed: the mobile dropdown caret (the small triangle next to menu items with submenus) had no color of its own and was silently inheriting whatever color happened to cascade to it. It now explicitly uses the Menu Color when closed and the Primary Color when open, so it always matches the chosen color scheme and visibly indicates open/closed state.
* Removed the `@version` line from every theme file's docblock. These had drifted out of sync repeatedly throughout this theme's development (several files were still showing 1.7.8 long after dozens of real releases) and never added information beyond what style.css's own Version: header and the MEC_THEME_VERSION constant already provide authoritatively. Removing them eliminates a stale, easily-forgotten second version trail rather than trying to keep 29 individual file headers in sync on every release going forward.

= 1.7.26 =
* Fixed: pages set as the static front page (Settings > Reading > "A static page") were displaying their admin-facing title (e.g. "FRONT PAGE") as visible content on the live site. The entry-header block is now suppressed entirely on the front page, which also removes the gap that appeared below the header when using a title-hiding plugin (the gap was the header's own margin-bottom rendering even when its content was hidden).
* Improved: sidebar widget margin and padding reduced on mobile/tablet (<=768px) to tighten the vertical spacing between stacked widgets, particularly the noticeable gap above the Search widget. Desktop spacing is unchanged.
* Note: 1.7.25's change (hamburger panel top padding reduced from 80px to 24px) is also included in this build.

= 1.7.24 =
* Fixed: turning OFF "Show label" on a sidebar Search widget (the Gutenberg core Search block) triggered the same "page needs pinching, vertical gap" symptom, isolated and confirmed via direct DevTools testing on a real device. Root cause: WordPress core applies its standard .screen-reader-text utility class to the hidden label (correct, standard behavior -- the label is hidden visually but kept for screen readers). That class is normally clipped to exactly 1x1px via position:absolute + clip-path + a negative margin. This theme's .widget rule (added in 1.7.15/1.7.16 to fix long-URL overflow) applies overflow-wrap: anywhere to everything inside a widget, including this label -- and on at least some mobile browsers, that combination interfered with the 1px-clipping technique, producing a full-width position:absolute box instead of an invisible one, which affected the rest of the page's layout.
* Excluded .screen-reader-text from inheriting .widget's overflow-wrap, and added a defensive, explicit .screen-reader-text rule pinning down its critical sizing properties directly, as a second safety net.
* This is the third distinct way overflow-wrap: anywhere has interacted badly with a sizing-sensitive element in this theme (the others: a flex sidebar in 1.7.15, addressed in 1.7.16). If you've been keeping "Show label" forced ON as a workaround, it should no longer be necessary after this update.

= 1.7.23 =
* Different finding this time: direct DevTools measurement with the menu open showed body at exactly the viewport width, no horizontal scrollbar, no overflow at all -- meaning 1.7.21/1.7.22's scrollbar-width fixes were addressing a real, separate issue, but not the one actually being seen and reported as "a vertical gap." 
* The actual explanation: .mobile-menu-panel (the off-canvas menu) is only 80% of the screen width by design, sliding in from the right with the remaining 20% intentionally left showing the page behind it (so there's room to tap outside the panel to close it) -- but no backdrop/overlay ever existed to dim that area or indicate it was intentional. That uncovered strip, with nothing visually marking it as deliberate, is what was being seen and described as a gap -- not a layout overflow, since there wasn't one.
* Added a dimmed backdrop behind the mobile menu panel, visible only while the menu is open, plus tap-to-close on it (previously you could only close via the explicit X button or Escape key). 
* The overflow-wrap and scrollbar-width fixes from 1.7.16-1.7.22 all remain in place; they were correct fixes for real, separate issues, just not this particular visual report.

= 1.7.22 =
* Fixed: 1.7.21 corrected the `overflow` shorthand bug (it was unintentionally also touching overflow-x), but testing on a real device showed the gap survived anyway -- because overflow-y: hidden BY ITSELF is still enough to remove body's vertical scrollbar on browsers/devices using classic, non-overlay scrollbars, and removing a scrollbar after the page has already laid out still grows the available content width regardless of which overflow axis caused it.
* The actual complete fix: navigation.js now measures the real scrollbar width (window.innerWidth minus document.documentElement.clientWidth) the first time the menu opens, and applies that exact value as `padding-right` on body at the same instant the scrollbar is hidden -- so the body's total width never changes, regardless of whether the scrollbar disappearing would have grown it. On devices using overlay scrollbars (most mobile browsers, recent macOS), the measured width is correctly 0 and this is a harmless no-op. Removed and restored cleanly when the menu closes.
* This is a standard, well-documented technique for exactly this class of problem (locking scroll without triggering a layout shift), not something specific to this theme -- 1.7.21's analysis of the root cause was correct, the fix just needed one more piece to be complete.

= 1.7.21 =
* Fixed: the long-running "page can be pinched/squeezed, leaving a vertical gap on one edge" issue -- the real root cause, finally confirmed by reproducing it from a fresh install with no content, no plugins, and no custom CSS at all, triggered simply by opening the mobile hamburger menu. navigation.js locked background scrolling while the mobile menu panel was open by setting `document.body.style.overflow = 'hidden'` -- the shorthand `overflow` property, which sets BOTH overflow-x and overflow-y at once. As an inline style, this overrides style.css's own `overflow-x: hidden` on body (inline styles always beat stylesheet rules). The result: overflow-y flipped from its normal scrollable state to hidden the instant the menu opened, removing body's vertical scrollbar -- and removing a scrollbar after the page has already been laid out grows the available viewport width, which not every already-rendered element recomputes cleanly. This explains every previous report of the gap: it was never about long URLs, sticky headers, caching, or any specific widget -- those things were coincidental to pages where the menu happened to get opened during testing. Fixed by changing both the open and close handlers to set `overflowY` specifically instead of the `overflow` shorthand, leaving overflow-x exactly as the stylesheet already defines it.
* Also fixed: `isMobile.addListener()`, a deprecated MediaQueryList method, replaced with the standard `addEventListener('change', ...)`. Flagged in this theme's original code audit but never actually applied until now.
* Earlier overflow-wrap fixes (1.7.16-1.7.20) for long URLs in widgets/titles/post content are still valid, good defensive practices, and remain in place -- they just were never the cause of this particular, more visible bug.

= 1.7.20 =
* Fixed: single blog posts never respected the Blog Settings panel (Post Meta show/hide/custom, individual date/author/comments toggles) since the very beginning. single.php requests get_template_part('content', get_post_type()), which for a standard post should load template-parts/content-post.php -- but that file never existed, so WordPress silently fell back to the generic template-parts/content.php, which hardcodes its entry-meta output with no reference to any Customizer setting at all. Added the missing content-post.php, ported from the same working logic content-blog.php (the blog-listing template) already used correctly. If you were using a "Hide Post Meta" custom CSS rule as a workaround, it's no longer needed -- the actual Customizer toggle now works.
* Fixed: front-page.php had its own separate, hardcoded post loop (not using get_template_part at all), which ignored every Blog Settings option -- no excerpt length, no featured image size, no read-more text/toggle, no meta controls, just the full post body dumped unconditionally. This was also the source of a long-URL-in-post-content overflow issue specifically on the front page (confirmed: the same long URL wrapped correctly in the sidebar widget but not in the front-page post loop) -- front-page.php's bare <article> markup didn't share the same protective styling as the properly-built template parts. Replaced the hardcoded loop with the same get_template_part('content', 'blog') call index.php/archive.php/search.php already use.
* Added overflow-wrap: anywhere directly to the base `article` rule as a final safety net, since front-page.php's old hardcoded markup rendered straight into a bare <article> with none of the wrapper elements (.entry-content-wrapper) that already had this protection.
* Together, these two template fixes mean every blog-post-rendering context in the theme (front page, blog index, archives, search results, and now single posts) goes through the same Customizer-aware, long-URL-safe code path.

= 1.7.19 =
* Improved: footer copyright text and the "Theme by Biswajit" credit line now sit inline on one row on desktop/tablet (separated by a dash), and stack on separate lines on mobile (768px and below) where the combined text would otherwise wrap awkwardly.
* Improved: the credit link's color is now automatically computed for readability against whatever Footer Background color is chosen in the Customizer, using a standard relative-luminance calculation (the same weighting used in WCAG contrast formulas) -- light text on dark backgrounds, dark text on light backgrounds, with no extra color setting to manage. New helper: `mec_theme_get_contrast_color()` in inc/customizer-css.php, exposed as the `--mec-footer-credit-color` CSS variable.
* No other settings changed; the copyright text's own color is untouched and still fully Customizer-controlled as before.

= 1.7.18 =
* Fixed: `<i>` and `<b>` tags typed into the Customizer's Copyright Text field were silently stripped by `wp_kses()`, since the tag whitelist only included `a`, `br`, `strong`, `em`, and `span`. Added `i` and `b` to the whitelist. (`<em>`/`<strong>` were already supported and are the more semantically correct choice, but `<i>`/`<b>` now work too rather than disappearing without warning.)
* Added a small "Theme by Biswajit" credit line beneath the copyright text in the footer, linking to https://github.com/bungakku. Built with the same `wp_kses()` discipline as the copyright text above it (translatable name string + escaped URL, final output still passed through `wp_kses` regardless), so it follows the theme's existing security pattern rather than introducing a new one.
* No Customizer setting controls this -- it's a fixed, small credit line, consistent with how many themes acknowledge their author. Styled to sit visually subordinate to the copyright text (smaller, slightly muted) rather than compete with it.

= 1.7.17 =
* Fixed: 1.7.16's overflow-wrap fix only covered `.widget` and `.entry-content`. Confirmed by direct testing that a long unbroken URL (e.g. a Facebook share link or Google Drive link from imported post content) could still overflow the page when it appeared in a post title or post meta -- neither of which had this protection. Added `overflow-wrap: anywhere` to `.entry-title`, `.entry-meta`, and as a broad safety net, to all headings (h1-h6) site-wide, since titles render in archive listings, related posts, and search results, not only the single-post template.
* This was confirmed against a real reproduction: removing long URLs from imported post content fixed the overflow even with all plugins and widgets active; restoring the URLs reproduced it. This release closes the remaining gap rather than relying on .widget/.entry-content alone.

= 1.7.16 =
* Fixed a regression introduced in 1.7.15: the `overflow-wrap: break-word` fix added to `.widget` had an unintended side effect on real sites -- `.secondary` (the sidebar widget column) is a flex child of `.content-area` (display: flex), and `break-word` (the legacy property) does not factor possible word-breaks into an element's min-content size calculation. This meant a flex child containing a long unbroken string got SIZED as if the string could not break at all, stretching the sidebar itself to fit it -- the overflow showed up one level up (the whole sidebar/page), not inside the text that was supposedly being wrapped. This was confirmed on a live test site: a Custom HTML "news ticker" widget, completely unchanged since 1.7.12, started overflowing the moment 1.7.15 was installed and stopped the moment it was reverted.
* Changed `.widget` and `.entry-content` to use `overflow-wrap: anywhere` instead of `break-word`. `anywhere` does not have the min-content calculation problem and is the current standard replacement; `word-wrap: break-word` is kept only as a fallback for very old browsers without `overflow-wrap` support.
* If you installed 1.7.15 and saw sidebar/page overflow that wasn't present before, this release fixes it with no other changes needed.

= 1.7.15 =
* Fixed: the long-running "vertical gap / needs pinch-to-fit on mobile" issue, finally root-caused. It traced to imported post content containing long, unbroken URLs with no spaces or hyphens (e.g. Google Drive links pasted directly as plain text, visible in the "Campus News" sidebar widget after importing posts from another site). A browser treats a string like that as a single unbreakable "word" and will not wrap it at the container edge by default -- if it's wider than the sidebar column, it forces that column wider than its parent, which can push the whole page wider than the viewport. This had nothing to do with sticky headers, caching, or any of the other things ruled out in 1.7.11-1.7.14 along the way -- it only appeared once content containing this pattern existed on the site, which is why it tracked so precisely with "started after I imported some posts."
* Added `overflow-wrap: break-word` (with the `word-wrap` fallback for older browsers) to the base `.widget` rule -- covering every sidebar widget at once -- and to `.entry-content`, covering post/page body text. Any future long unbroken string in either location will now wrap inside its container instead of forcing it wider.
* The theme already had this exact protection on mobile navigation menu links (added at some earlier point, scoped only to `.main-navigation a`) -- this release extends the same fix to the two places it was actually needed.

= 1.7.14 =
* Improved: reduced .container side padding from 20px to 10px on phones (480px and below) only. Tablet (481-768px) and desktop are unchanged at 20px. This was a direct request after testing 1.7.12 live -- 20px felt like more side margin than needed on small screens, eating into already-limited width.
* No structural change: this only adjusts one padding value inside an existing mobile media query block. Sidebar layout, header layout, and the admission-form-wrapper fix from 1.7.12 are unaffected (the form's inputs automatically gain a small amount of extra usable width as a side effect, since they fill their parent's width).

= 1.7.13 =
* Improved: introduced a small spacing scale (`--mec-space-xs` through `--mec-space-xl`, 8px/12px/20px/32px/48px) as CSS variables, and applied it to the main layout and widget spacing that was previously a mix of one-off values (15px, 20px, 30px, 40px used inconsistently in different places). Applied to: the sidebar/content gap, article card padding and spacing, entry header/title margins, sidebar widget padding and title spacing, and the footer widgets area.
* This is a spacing-only refinement -- sidebar structure, the has-sidebar/no-sidebar logic, sidebar-left/sidebar-right ordering, container width, colors, typography, and all Customizer settings are completely unchanged. Any custom CSS already added via Customizer > Additional CSS (e.g. a widget margin override) continues to apply on top of this exactly as before, since theme defaults always load first.
* No settings or markup changed; this only touches numeric spacing values in style.css.

= 1.7.12 =
* Fixed: pages using the "Online Admission Manager" plugin's application form needed to be pinched/zoomed out to fit on mobile and tablet -- the plugin's form markup places multiple label+input pairs on a single line (e.g. Father's Name / Father's Contact 1 / Father's Contact 2 in one `<p>`, and six fields plus a button in each "Academic Record" row) with no responsive CSS of its own, so the unstyled default input widths comfortably exceeded any phone screen and forced the whole page wider than the viewport.
* Added a new "Third-Party Plugin Compatibility: Online Admission Manager" section to style.css, scoped entirely to `.admission-form-wrapper` (the plugin's own wrapper class) so it cannot affect anything else on the site. Every label+input pair now stacks on its own line and inputs fill the available width; the "Academic Record" repeatable row does the same. Form inputs are also set to 16px font-size, which prevents iOS Safari's auto-zoom-on-focus behavior -- a separate small annoyance on the same page.
* This is a CSS-only override living in the theme, not a change to the plugin itself, so it survives plugin updates and doesn't require editing any plugin files. If "Online Admission Manager" is not installed/active, this section has no effect.

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

Developed by: Biswajit Thokchom
Icons are inline SVGs created by the author.
No external libraries or assets are used.