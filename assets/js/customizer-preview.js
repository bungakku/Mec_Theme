/**
 * Customizer preview enhancements for MEC Theme
 * Handles live updates for site description hiding on tablet/mobile,
 * and live updates for tagline alignment.
 *
 * @package MEC_Theme
 * @version 1.7.8
 */
(function($, api) {
    'use strict';

    var $style = $('<style id="mec-theme-hide-description-preview"></style>').appendTo('head');

    function updateDescriptionVisibility() {
        var hideTablet = api('mec_theme_hide_description_tablet').get();
        var hideMobile = api('mec_theme_hide_description_mobile').get();
        var css = '';

        if (hideTablet) {
            css += '@media (min-width: 481px) and (max-width: 768px) { .site-description { display: none !important; } } ';
        }
        if (hideMobile) {
            css += '@media (max-width: 480px) { .site-description { display: none !important; } } ';
        }

        $style.html(css);
    }

    api('mec_theme_hide_description_tablet', function(setting) {
        setting.bind(updateDescriptionVisibility);
    });
    api('mec_theme_hide_description_mobile', function(setting) {
        setting.bind(updateDescriptionVisibility);
    });

    updateDescriptionVisibility();

    var validTaglineAlign = ['left', 'center', 'right'];

    function updateTaglineAlign(value) {
        if (validTaglineAlign.indexOf(value) === -1) {
            value = 'center';
        }
        document.documentElement.style.setProperty('--mec-tagline-align', value);
    }

    api('mec_theme_tagline_align', function(setting) {
        updateTaglineAlign(setting.get());
        setting.bind(updateTaglineAlign);
    });

})(jQuery, wp.customize);
