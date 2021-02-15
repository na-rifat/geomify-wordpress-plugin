(function ($) {
    $(document).ready(function (e) {
        let me = new geomify();
        me.copyright();
        me.jumpToTop();
        // copyright();
        // Jump to top function
    });
})(jQuery);

/**
 * Puts copright text in footer
 */
function copyright() {}

/**
 * Elementor widgets functions
 */

class geomify {
    jumpToTop() {
        jQuery(`.jump-to-top`).click(() => {
            jQuery("html, body").animate({ scrollTop: 0 }, "slow");
        });
    }

    copyright() {
        let $ = jQuery;
        let cyear = new Date().getFullYear();
        $(`.copy-right-text`).html(`Copyright &copy; ${cyear} Geomify`);
    }
}
