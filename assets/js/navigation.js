/**
 * File navigation.js.
 * Handles mobile menu toggling (off-canvas panel) and submenu dropdowns.
 * Includes aria-expanded for submenu parents and focus management.
 *
 * @package MEC_Theme
 */
(function() {
    'use strict';

    var isMobile = window.matchMedia('(max-width: 768px)');

    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.querySelector('.menu-toggle');
        const navigation = document.querySelector('.main-navigation');
        const mobilePanel = document.querySelector('.mobile-menu-panel');
        const closeBtn = document.querySelector('.mobile-menu-close');
        const backdrop = document.querySelector('.mobile-menu-backdrop');

        const vars = window.mecThemeVars || {};
        const defaultMenuText = vars.menuText || 'Menu';
        const defaultCloseText = vars.closeText || 'Close';

        if (!menuToggle || !navigation || !mobilePanel) return;

        var cachedScrollbarWidth = null;
        function getScrollbarWidth() {
            if (cachedScrollbarWidth === null) {
                cachedScrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
            }
            return cachedScrollbarWidth;
        }

        // Fixed in 1.7.57 (audit finding, Recommended #11): the off-canvas
        // mobile menu moved focus to the close button on open and closed on
        // Escape, but nothing stopped Tab from carrying focus straight out
        // of the panel into the rest of the page while it was still open --
        // a real gap on this theme's core mobile interactive component.
        // Scoped narrowly: this only traps Tab/Shift+Tab at the panel's
        // own existing first/last focusable elements (which already start
        // at the close button, matching the existing focus-on-open above);
        // it does not change which elements inside the panel are reachable.
        function getFocusableElements() {
            return mobilePanel.querySelectorAll(
                'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
            );
        }

        function trapFocus(e) {
            if (e.key !== 'Tab') return;
            var focusable = getFocusableElements();
            if (!focusable.length) return;
            var first = focusable[0];
            var last = focusable[focusable.length - 1];

            if (e.shiftKey) {
                if (document.activeElement === first) {
                    e.preventDefault();
                    last.focus();
                }
            } else if (document.activeElement === last) {
                e.preventDefault();
                first.focus();
            }
        }

        menuToggle.setAttribute('aria-expanded', 'false');
        menuToggle.setAttribute('aria-controls', 'primary-menu');

        function toggleMenu() {
            navigation.classList.toggle('toggled');
            const isExpanded = navigation.classList.contains('toggled');
            menuToggle.setAttribute('aria-expanded', isExpanded);

            if (isExpanded) {
                menuToggle.innerHTML = '<span aria-hidden="true">✕</span> ' + defaultCloseText;
                var sbWidth = getScrollbarWidth();
                document.body.style.overflowY = 'hidden';
                if (sbWidth > 0) {
                    document.body.style.paddingRight = sbWidth + 'px';
                }
                document.querySelectorAll('.main-navigation li.menu-item-has-children').forEach(function(item) {
                    item.classList.remove('toggled');
                    const parentLink = item.querySelector('> a');
                    if (parentLink) parentLink.setAttribute('aria-expanded', 'false');
                });
                if (closeBtn) closeBtn.focus();
                document.addEventListener('keydown', trapFocus);
            } else {
                menuToggle.innerHTML = '<span aria-hidden="true">☰</span> ' + defaultMenuText;
                document.body.style.overflowY = '';
                document.body.style.paddingRight = '';
                document.querySelectorAll('.main-navigation li.menu-item-has-children.toggled').forEach(function(item) {
                    item.classList.remove('toggled');
                    const parentLink = item.querySelector('> a');
                    if (parentLink) parentLink.setAttribute('aria-expanded', 'false');
                });
                menuToggle.focus();
                document.removeEventListener('keydown', trapFocus);
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

        if (backdrop) {
            backdrop.addEventListener('click', function(e) {
                e.preventDefault();
                if (navigation.classList.contains('toggled')) toggleMenu();
            });
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && navigation.classList.contains('toggled')) toggleMenu();
        });

        navigation.addEventListener('click', function(e) {
            const link = e.target.closest('.menu-item-has-children > a');
            if (!link) return;

            const parentLi = link.closest('li');
            if (!parentLi || !parentLi.classList.contains('menu-item-has-children')) return;

            if (window.matchMedia('(max-width: 768px)').matches) {
                e.preventDefault();
                e.stopPropagation();

                const isExpanded = parentLi.classList.contains('toggled');
                parentLi.classList.toggle('toggled');
                link.setAttribute('aria-expanded', !isExpanded);

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
