(function ($) {
    $(document).ready(function (e) {});
    copyright();
})(jQuery);

/**
 * Puts copright text in footer
 */
function copyright() {
    let $ = jQuery;
    let cyear = new Date().getFullYear();
    $(`.copy-right-text`).html(`Copyright &copy; ${cyear} Geomify`);
}

/**
 * Elementor widgets functions
 */

