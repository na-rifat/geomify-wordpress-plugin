(function ($) {
    $(document).ready(function (e) {
        let me = new geomify();
        me.initialize();
    });
})(jQuery);

/**
 * Handles Geomify scripting functions
 */
class geomify {
    construct() {
        this.ajax_url = goemify.ajax_url;
        this.went_wrong = geomify.went.wrong;
        this.$ = jQuery;
    }
    /**
     * Jumps to top of the page
     */
    jumpToTop() {
        jQuery(`.jump-to-top`).click(() => {
            jQuery("html, body").animate({ scrollTop: 0 }, "slow");
        });
    }

    /**
     * Shows copright text
     *
     * Dynamic copyright year
     */
    copyright() {
        let $ = jQuery;
        let cyear = new Date().getFullYear();
        $(`.copy-right-text`).html(`Copyright &copy; ${cyear} Geomify`);
    }

    /**
     * Creates a lightbox
     *
     * @param {string} elements
     */
    ligbox(elements) {
        $(`body`).append(
            `<div class="geomify-lightbox"><div><div class="close-lightbox">X</div>${elements}</div></div>`
        );
        $(`.close-lighbox`).on(`click`, function (e) {
            $(`geomify-lightbox`).hide(500, function (e) {
                $(this).remove();
            });
        });
    }

    /**
     * Gets a shrotcode using ajax request
     *
     * @param {string} shortcode
     */
    getShortcode(shortcode) {
        $.ajax({
            type: "POST",
            url: this.ajax_url,
            data: {
                action: `get_shortcode`,
                shortcode,
            },
            dataType: "JSON",
            success: function (res) {
                if (res.success) {
                    this.lightbox(res.data.shortcode);
                } else {
                    alert(res.data.msg);
                }
            },
            error: function (res) {
                alert(this.went_wrong);
            },
        });
    }

    buttonActions() {
        this.jumpToTop();
        this.$(`.plant-process-form`).on(`click`, function (e) {
            this.getShortcode(`[contact-form-7 id="593" title="Plant & Process"]`);
        });
    }

    initialize() {
        this.buttonActions();
        this.copyright();
    }
}
