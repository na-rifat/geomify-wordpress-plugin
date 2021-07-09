function geomifyLightbox(content) {
    $(`body`).append(
        `<div class="geomify-admin-lightbox"><div>${content}</div></div>`
    );
}
function geomifyMessage(message, type = `success`) {
    let $ = jQuery;
    let typecClass = `type-${type}`;
    $(`body`).append(
        `<div class="geomify-message-holder"><div class="geomify-message ${typecClass}">${message}</div></div>`
    );

    let messages = $(`.geomify-message-holder`);
    let current = messages.eq(messages.length - 1);

    setTimeout(() => {
        current.hide(500, function (e) {
            current.remove();
        });
    }, 3000);
}

/**
 * Creates and prompt a lightbox with dynamic content
 *
 * @param {string} content
 * @param {string} top
 * @param {string} bottom
 */
// function lightBox(content = ``, top = ``, bottom = ``) {
//     let $ = jQuery;

//     let el = `<div class="geomify-lightbox-container">
//     <div class="geomify-lightbox">
//         <div class="geomify-lightbox-topbar">${top}<div class="lightbox-close">X</div></div>
//         <div class="geomify-lightbox-content">${content}</div>
//         <div class="geomify-lightbox-bottombar">${bottom}</div>
//     </div>
// </div>`;

//     $(`body`).append(el);
//     // $(`.geomify-lightbox-container`).hide(0, function (e) {
//     //     $(this).show(500);
//     // });
//     $(`.geomify-lightbox`).show(500);

//     $(`.geomify-lightbox-container .lightbox-close`).on(`click`, function (e) {
//         hideLightbox();
//     });
// }
function lightBox(content = ``, top = ``, bottom = ``) {
    let $ = jQuery;
    $(`.geomify-lightbox`).parent().remove();

    let el = `<div class="geomify-lightbox-container">
        <div class="geomify-lightbox geo-scroll">         
        <div class="lightbox-close">X</div>
        ${content}
        </div>
    </div>`;

    $(`body`).append(el);
    // $(`.geomify-lightbox`).html($(`.geomify-lightbox`).html());

    $(`.geomify-lightbox`).show(1000);

    $(`.geomify-lightbox-container .lightbox-close`).on(`click`, function (e) {
        hideLightbox();
    });
}

function hideLightbox() {
    let $ = jQuery;
    $(`.geomify-lightbox`).hide(500, function (e) {
        $(this).parent().remove();
    });
}

/**
 * Gets a shrotcode using ajax request
 *
 * @param {string} shortcode
 */
function getShortcode(shortcode) {
    let $ = jQuery;

    $.ajax({
        type: "POST",
        url: geomify.ajax_url,
        data: {
            action: `get_shortcode`,
            shortcode,
        },
        dataType: "JSON",
        success: function (res) {
            console.log(res);
            if (res.success) {
                lightBox(res.data.shortcode);
            } else {
                geomifyMessage(res.data.msg, `failed`);
            }
        },
        error: function (res) {
            alert(geomify.went_wrong);
        },
    });
}

function loaderProgress(selector, progress) {
    let $ = jQuery;

    $(selector)
        .find(`.progress-count`)
        .css({
            width: `${progress}%`,
        });
    $(selector)
        .find(`.progress-count-text`)
        .text(parseInt(progress) + `%`);
}

function geomifyValidateFields(selector, textColor = `#fff`) {
    let $ = jQuery;
    let fields = $(selector).find(
        `input:not([type="submit"]):not([type="button"]), textarea, select`
    );
    let result = true;

    $(fields).each(function (e) {
        // $(this).css({
        //     backgroundColor: `red`,
        // });
        // result = false;
        // return;
        if (
            ($(this).prop("tagName") == "INPUT" ||
                $(this).prop("tagName") == "TEXTAREA") &&
            $(this).attr(`required`) == `required` &&
            $(this).val().length == 0
        ) {
            $(this).after(
                `<div class="geomify-empty-input" style="color: ${textColor};">This field is required</div>`
            );

            result = false;
            return;
        }

        if (
            $(this).prop("tagName") == "SELECT" &&
            $(this).attr(`required`) == `required` &&
            $(this).parent().find("option:selected").text() ==
                $(this).parent().find("option:first").text()
        ) {
            $(this).after(
                `<div class="geomify-empty-input" style="color: ${textColor};">This field is required</div>`
            );
            result = false;
            return;
        }
    });

    setTimeout(() => {
        $(`.geomify-empty-input`).hide(500, function (e) {
            $(this).remove();
        });
    }, 2000);

    return result;
}

function lightboxVideo(src) {
    player = `<div class="geomify-lightbox-video"><video controls autoplay><source src="${src}" type="video/mp4"></video></div>`;
    lightBox(player);
}

function brandLoading(selector, bgcolor = `white`) {
    let $ = jQuery;

    $(selector).addClass(`brand-loading-parent`);

    $(selector)
        .append(
            `<div class="brand-loading"><img src="${geomify.logo_url}" /></div>`
        )
        .find(`.brand-loading`)
        .css({
            backgroundColor: bgcolor,
        })
        .find(`img`)
        .css({
            filter: `invert(1)`,
        });
}
function endBrandLoading(selector) {
    let $ = jQuery;
    $(selector)
        .removeClass(`brand-loading-parent`)
        .find(`.brand-loading`)
        .remove();
}
