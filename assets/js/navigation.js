/**
 * File navigation.js.
 * Handles mobile menu toggling (off-canvas panel) and submenu dropdowns.
 * Includes aria-expanded for submenu parents and focus management.
 *
 * @package MEC_Theme
 * @version 1.7.6
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
                document.body.style.overflow = 'hidden';
                // Collapse all submenus when opening
                document.querySelectorAll('.main-navigation li.menu-item-has-children').forEach(function(item) {
                    item.classList.remove('toggled');
                    const parentLink = item.querySelector('> a');
                    if (parentLink) parentLink.setAttribute('aria-expanded', 'false');
                });
                if (closeBtn) closeBtn.focus();
            } else {
                menuToggle.innerHTML = '☰ ' + defaultMenuText;
                document.body.style.overflow = '';
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
        isMobile.addListener(checkScreenSize);
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(checkScreenSize, 250);
        });
    });
})();