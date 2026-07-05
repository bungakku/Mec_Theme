/**
 * File navigation.js.
 * Handles mobile menu toggling (off-canvas panel) and submenu dropdowns.
 * Includes aria-expanded for submenu parents and focus management.
 *
 * @package MEC_Theme
 * @version 1.7.8
 */
(function() {
    'use strict';

    var isMobile = window.matchMedia('(max-width: 768px)');

    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.querySelector('.menu-toggle');
        const navigation = document.querySelector('.main-navigation');
        const mobilePanel = document.querySelector('.mobile-menu-panel');
        const closeBtn = document.querySelector('.mobile-menu-close');

        const vars = window.mecThemeVars || {};
        const defaultMenuText = vars.menuText || 'Menu';
        const defaultCloseText = vars.closeText || 'Close';

        if (!menuToggle || !navigation || !mobilePanel) return;

        menuToggle.setAttribute('aria-expanded', 'false');
        menuToggle.setAttribute('aria-controls', 'primary-menu');

        // Toggle mobile panel
        function toggleMenu() {
            navigation.classList.toggle('toggled');
            const isExpanded = navigation.classList.contains('toggled');
            menuToggle.setAttribute('aria-expanded', isExpanded);

            if (isExpanded) {
                menuToggle.innerHTML = '✕ ' + defaultCloseText;
                // IMPORTANT: only touch overflow-y here, never the `overflow`
                // shorthand. The shorthand sets BOTH overflow-x and
                // overflow-y at once -- and since this is an inline style,
                // it overrides style.css's own `overflow-x: hidden` on body
                // (inline styles always win over stylesheet rules). Setting
                // the shorthand was flipping overflow-y from its normal
                // scrollable state to hidden, which removes body's vertical
                // scrollbar the instant the menu opens. Removing a
                // scrollbar after the page has already been laid out grows
                // the available viewport width by however many pixels that
                // scrollbar took up, and not every already-rendered element
                // recomputes its width cleanly in response -- this was the
                // actual root cause of the long-running "page can be
                // pinched/squeezed, leaving a vertical gap" issue, confirmed
                // reproduced on three separate fresh installs by opening the
                // hamburger menu. Restricting this to overflow-y avoids the
                // scrollbar-removal reflow entirely while still correctly
                // locking background scroll behind the open mobile panel.
                document.body.style.overflowY = 'hidden';
                // Collapse all submenus when opening
                document.querySelectorAll('.main-navigation li.menu-item-has-children').forEach(function(item) {
                    item.classList.remove('toggled');
                    const parentLink = item.querySelector('> a');
                    if (parentLink) parentLink.setAttribute('aria-expanded', 'false');
                });
                if (closeBtn) closeBtn.focus();
            } else {
                menuToggle.innerHTML = '☰ ' + defaultMenuText;
                document.body.style.overflowY = '';
                document.querySelectorAll('.main-navigation li.menu-item-has-children.toggled').forEach(function(item) {
                    item.classList.remove('toggled');
                    const parentLink = item.querySelector('> a');
                    if (parentLink) parentLink.setAttribute('aria-expanded', 'false');
                });
                menuToggle.focus();
            }
        }

        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            toggleMenu();
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (navigation.classList.contains('toggled')) toggleMenu();
            });
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && navigation.classList.contains('toggled')) toggleMenu();
        });

        // ===== Submenu toggling – event delegation (works even if menu loads later) =====
        navigation.addEventListener('click', function(e) {
            // Find the clicked link that is a direct child of a menu-item-has-children
            const link = e.target.closest('.menu-item-has-children > a');
            if (!link) return;

            const parentLi = link.closest('li');
            if (!parentLi || !parentLi.classList.contains('menu-item-has-children')) return;

            // Only apply on mobile screen width
            if (window.matchMedia('(max-width: 768px)').matches) {
                e.preventDefault();
                e.stopPropagation();

                const isExpanded = parentLi.classList.contains('toggled');
                parentLi.classList.toggle('toggled');
                link.setAttribute('aria-expanded', !isExpanded);

                // Collapse siblings (optional, improves UX)
                const siblings = parentLi.parentElement.children;
                for (let sibling of siblings) {
                    if (sibling !== parentLi && sibling.classList.contains('toggled')) {
                        sibling.classList.remove('toggled');
                        const siblingLink = sibling.querySelector('> a');
                        if (siblingLink) siblingLink.setAttribute('aria-expanded', 'false');
                    }
                }
            }
        });

        // Reset on resize
        function resetMobileDropdowns() {
            document.querySelectorAll('.main-navigation li.menu-item-has-children').forEach(function(item) {
                item.classList.remove('toggled');
                const parentLink = item.querySelector('> a');
                if (parentLink) parentLink.setAttribute('aria-expanded', 'false');
            });
        }

        function checkScreenSize() {
            if (!isMobile.matches) {
                resetMobileDropdowns();
                if (navigation.classList.contains('toggled')) toggleMenu();
            }
        }

        checkScreenSize();
        isMobile.addEventListener('change', checkScreenSize);
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(checkScreenSize, 250);
        });
    });
})();