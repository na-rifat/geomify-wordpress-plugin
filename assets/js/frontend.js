"use strict";
(function ($) {
    $(document).ready(function (e) {
        let me = new geomifyMain();
        me.initialize();
    });
})(jQuery);

/**
 * Handles Geomify scripting functions
 */
class geomifyMain {
    construct() {
        this.$ = jQuery;
        this.ajax_url = goemify.ajax_url;
        this.went_wrong = geomify.went.wrong;
        this.self = this;

        this.elements.plantProcessContactButton = $(`#plant-process-contact`);
        this.elements.contactBtn = $(`.contact-us`);
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
                    lightBox(res.data.shortcode);
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
        this.plantProcessContactButton.on(`click`, function (e) {
            e.preventDefault();
            this.getShortcode(
                `[contact-form-7 id="593" title="Plant & Process"]`
            );
        });

        this.elements.contactBtn.on(`click`, function (e) {
            e.preventDefault();
            this.getShortcode(`[contact-form-7 id="735" title="Contact us"]`);
        });
    }

    initialize() {
        this.buttonActions();
        this.copyright();
    }
}

/**
 * Creates and prompt a lightbox with dynamic content
 *
 * @param {string} content
 * @param {string} top
 * @param {string} bottom
 */
function lightBox(content = ``, top = ``, bottom = ``) {
    let $ = jQuery;

    let el = `<div class="geomify-lightbox-container">
        <div class="geomify-lightbox">
            <div class="geomify-lightbox-topbar">${top}<div class="lightbox-close">X</div></div>
            <div class="geomify-lightbox-content">${content}</div>
            <div class="geomify-lightbox-bottombar">${bottom}</div>
        </div>
    </div>`;

    $(`body`).append(el);
    $(`.geomify-lightbox-container`).hide(0, function (e) {
        $(this).show(500);
    });

    $(`.geomify-lightbox-container .lightbox-close`).on(`click`, function (e) {
        $(`.geomify-lightbox-container`).hide(500, function (e) {
            $(this).remove();
        });
    });
}

// Scroll effect
(function ($) {
    $(document).on(`scroll`, function (e) {
        if ($(this).scrollTop() == 0) {
            // Top of the page
            $(`.geomify-main-header`).removeClass(`floating`);
        } else {
            // Scrolling down the page
            $(`.geomify-main-header`).addClass(`floating`);
        }
    });
})(jQuery);
