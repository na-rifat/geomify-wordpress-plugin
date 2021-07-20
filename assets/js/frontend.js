var geomifyUserFiles = new FormData();
var geomifyUserFilesArray = [];
var gTabIn = 0;
(function ($) {
    $(document).ready(function (e) {
        custom_cf7_submission();
        // multiStepForm();
        jumpToTop();
        geomifyTabNavigation();
        getPv();
        geomifyContactForm();
        filterTutorials();
        activateUser();
        gtabSwitcher();
        saveAcInfo();
        upgradeForm();
        fillUpUpgraded();
        showPassword();
        handleProjectViews();
        handleFileUpload();
        getQuote();
        partnerProgramsApply();
        educationalApply();
        dragnDropUploader();
        uploadUserFile();
        dltPm();
        startBasicForm();
        ckConsent();
        geoLogin();
        geoReset();
        udmHandle();
    });
})(jQuery);

// Scroll effect
(function ($) {
    $(document).on(`scroll ready`, function (e) {
        if ($(this).scrollTop() == 0) {
            // Top of the page
            $(`.geomify-main-header`).removeClass(`floating`);
            $(`.jump-to-top`).hide();
        } else {
            // Scrolling down the page
            $(`.geomify-main-header`).addClass(`floating`);
            $(`.jump-to-top`).slideDown();
        }

        $(`a[href="#"]`).on(`click`, function (e) {
            e.preventDefault();
        });
    });
})(jQuery);

/**
 * Customized contact form 7 submission
 */
function custom_cf7_submission() {
    let $ = jQuery;

    $(`.submit-cf7 .geomify-button`).on(`click`, function (e) {
        $(`.geomify-cf7-form .wpcf7-form input[type="submit"]`).click();
    });
}

/**
 * Jumps to top of the page
 */
function jumpToTop() {
    let $ = jQuery;

    jQuery(`.jump-to-top`).click(() => {
        jQuery("html, body").animate({ scrollTop: 0 }, jQuery(`body`).height());
    });
}

/**
 * Geomify multistep forms script
 */
function multiStepForm() {
    let $ = jQuery;

    let parent = $(`.geomify-ms-form-wrapper`);
    let success_shortcode = parent.data(`success_shortcode`);
    let steps = parent.find(`.geomify-ms-step`);
    let buttons = parent.find(`.geomify-ms-bottombar-item`);
    let stepIndicators = parent.find(`.geomify-ms-topbar-item`);
    let itemCount = steps.length;
    let current = 0;
    let form = parent.find(`form`);
    let formName = form.data(`name`);

    let jsForm = document.querySelector(`[data-name="${formName}"]`);

    stepIndicators.eq(current).toggleClass(`active-item-indicator`);

    let nextButton = parent.find(
        `.geomify-ms-bottombar-item:not(:last-child) > div:nth-child(2) div`
    );
    let previousButton = parent.find(
        `.geomify-ms-bottombar-item:not(:first-child) > div:nth-child(1)`
    );
    let submitButton = parent.find(
        `.geomify-ms-bottombar-item:last-child > div:nth-child(2)`
    );

    steps.eq(0).addClass(`acitve`);

    nextButton.on(`click`, function (e) {
        e.preventDefault();

        if (geomifyValidateFields(steps.eq(current)) == false) {
            return;
        }

        // Moving steps
        steps.eq(current).slideUp(200, function (e) {
            buttons.eq(current).css(`display`, `none`);
            steps.eq(current + 1).slideDown(200, function (e) {
                buttons.eq(current + 1).css(`display`, `flex`);
                stepIndicators.eq(current).toggleClass(`active-item-indicator`);
                stepIndicators
                    .eq(current + 1)
                    .toggleClass(`active-item-indicator`);

                current++;
            });
        });

        // Moving buttons
    });

    previousButton.on(`click`, function (e) {
        e.preventDefault();
        steps.eq(current).slideUp(200, function (e) {
            buttons.eq(current).css(`display`, `none`);
            steps.eq(current - 1).slideDown(200, function (e) {
                buttons.eq(current - 1).css(`display`, `flex`);
                stepIndicators.eq(current).toggleClass(`active-item-indicator`);
                stepIndicators
                    .eq(current - 1)
                    .toggleClass(`active-item-indicator`);

                current--;
            });
        });
    });

    submitButton.on(`click`, function (e) {
        e.preventDefault();

        parent.append(
            `<div class="brand-loading"><img src="${geomify.logo_url}" /></div>`
        );

        $(`.brand-loading`).css({
            backgroundColor: parent.css(`background-color`),
        });
        let jsForm = document.querySelector(`form[data-name="${formName}"]`);

        // console.log(jsForm);return;

        let data = new FormData(jsForm);

        data.append(`shortcode`, success_shortcode);
        data.append(`form_name`, formName);
        data.append(`action`, `${formName}_submit`);

        // console.log(data.get('action'))
        // return

        $.ajax({
            url: geomify.ajax_url,
            method: `POST`,
            contentType: false,
            processData: false,
            data,
            success: (res) => {
                console.clear();
                console.log(res);
                if (res.success) {
                    parent.html(res.data.template);
                    $(`.close-window`).on(`click`, hideLightbox);
                } else {
                    geomifyAlert(res.data.msg, `failed`);
                }
            },
            error: (res) => {},
            complete: (res) => {
                parent.find(`.brand-loading`).remove();
            },
        });
    });
}

/**
 * Shows an alert message at top of the body
 *
 * @param {string} text
 * @param {string} type
 */
function geomifyAlert(text, type = "success") {}

function geomifyTabNavigation() {
    return;
    $(`.geomify-dashboard-menu a`).on(`click`, function (e) {
        e.preventDefault();

        let browserId = $(`.geomify-dashboard-menu`).data(`browser`);
        let browser = $(`#${browserId}`);

        browser.attr(`src`, $(this).attr(`href`));
    });
}

function newPv() {
    let $ = jQuery;

    // Popup
    $(`.add-new-pv`).on(`click`, function (e) {
        $.ajax({
            type: "POST",
            url: geomify.ajax_url,
            data: {
                action: `get_new_pv_form`,
                nonce: geomify.new_pv_form_page_nonce,
            },
            dataType: `JSON`,
            success: function (response) {
                if (response.success) {
                    $(`body`).append(response.data.form);
                }
            },
        });
    });
}

/**
 * Get project views list
 */
function getPv() {
    let $ = jQuery;

    let data = {
        action: `get_pv`,
        nonce: geomify.get_pv_nonce,
    };

    let parent = $(`.pv-list`);

    parent.html(
        `<div class="brand-loading-invert"><img src="${geomify.logo_url}" /></div>`
    );

    $.ajax({
        type: "POST",
        url: geomify.ajax_url,
        data,
        dataType: "JSON",
        success: function (response) {
            if (response.success) {
                parent.html(response.data.views);
                newPv();
            }
        },
    });
}

function geomifyContactForm() {
    let $ = jQuery;

    $(`#submit-cf7`).on(`click`, function (e) {
        $(`.geomify-cf7-btn`).trigger(`click`);
    });
}

function viewTutorial() {
    let $ = jQuery;

    $(`.watch-tutorial`).on(`click`, function (e) {
        e.preventDefault();

        let src = $(this).attr(`href`);
        lightboxVideo(src);
    });
}

function tutorialList(filter) {
    let $ = jQuery;

    $.ajax({
        type: "POST",
        url: geomify.ajax_url,
        data: {
            action: `get_dashboard_tutorial_list`,
            nonce: geomify.get_dashboard_tutorial_list_nonce,
            filter,
        },
        dataType: `JSON`,
        success: function (response) {
            if (response.success) {
                $(`.geomify-tutorials-list-holder`).html(response.data.list);
            } else {
                geomifyMessage(response.data.msg, "failed");
            }
        },
    });
}

function filterTutorials() {
    let $ = jQuery;

    $(`.filter-tutorials`).on(`click`, function (e) {
        tutorialList($(`#tutorials-search`).val());
    });
}

function createSpace() {
    let $ = jQuery;

    $(`.create-space`).on(`click`, function (e) {
        e.preventDefault();

        let form = $(`.create-space-form`);
        let parent = $(`.registration-step`);

        if (!geomifyValidateFields(form, `red`)) {
            return;
        }

        let data = form.serialize();
        let step = form.data(`step`);

        brandLoading(parent);

        $.ajax({
            type: "POST",
            url: geomify.ajax_url,
            data:
                data +
                `&nonce=${geomify.create_space_nonce}&step=${step}&action=create_space`,
            dataType: "JSON",
            success: function (response) {
                if (response.success) {
                    parent.html(response.data.page);
                } else {
                    geomifyMessage(response.data.msg, `failed`);
                }
            },
            complete: function (res) {
                endBrandLoading(parent);
            },
        });
    });
}

function showPassword() {
    let $ = jQuery;
    let selectors = `.show-hide-password`;

    $(`.show-password`).on(`click`, function (e) {
        if ($(this).prop(`checked`) == true) {
            $(selectors).attr(`type`, `text`);
        } else {
            $(selectors).attr(`type`, `password`);
        }
    });
}
function activateUser() {
    let $ = jQuery;

    $(`.activate-user`).on(`click`, function (e) {
        e.preventDefault();
        let form = $(`.user-activation form`);

        if (geomifyValidateFields(form, `red`) == false) {
            return;
        }

        let data = form.serialize();
        let password = $(`#password`).val();
        let confirmPassword = $(`#confirm_password`).val();
        let key = form.data(`key`);
        let userId = form.data(`user`);

        if (password !== confirmPassword || password.length <= 8) {
            geomifyMessage(`Password mismatch!`, `failed`);
            return;
        }

        brandLoading(`.gtab-holder`);

        $.ajax({
            type: "POST",
            url: geomify.ajax_url,
            data:
                data +
                `&nonce=${geomify.activate_user_nonce}&action=activate_user_finally&key=${key}&user_id=${userId}`,
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                if (response.success) {
                    window.location.reload();
                } else {
                    geomifyMessage(response.data.msg, `failed`);
                }
            },
            complete: function (res) {
                endBrandLoading(`.gtab-holder`);
            },
        });
    });
}

function resetRegistrationForm() {
    let $ = jQuery;

    $(`.reset-create-space-form`).on(`click`, function (e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: geomify.ajax_url,
            data: {
                action: `get_registration_form`,
                nonce: geomify.get_registration_form_nonce,
            },
            dataType: `JSON`,
            success: function (response) {
                if (response.success) {
                    $(`.registration-step`).replaceWith(response.data.form);
                } else {
                    geomifyMessage(response.data.msg, `failed`);
                }
            },
        });
    });
}

function gtabSwitcher() {
    let $ = jQuery;
    let parent = $(`.gtab-holder`);
    let keys = parent.find(`.key-item`);
    let tabs = parent.find(`.gtab-item`);

    $(`.gtab-key-1 .key-item`).on(`click`, function (e) {
        let newKey = $(this);
        let newTab = tabs.eq(newKey.index());

        let activeKey = parent.find(`.key-item.active-item`);
        let activeTab = parent.find(`.gtab-item.active-item`);

        if (
            newKey.hasClass(`active-item`) ||
            $(this).parent().hasClass(`gtab-key-2`)
        ) {
            return;
        }

        activeTab.toggleClass(`active-item`);
        activeKey.toggleClass(`active-item`);

        newKey.toggleClass(`active-item`);
        newTab.toggleClass(`active-item`);
    });
}

function saveAcInfo() {
    let $ = jQuery;

    $(`.save-ac-info`).on(`click`, function (e) {
        e.preventDefault();

        let parent = $(this).parents(`.profile-section`);

        let package = parent.data(`profile_package`);
        let form = $(this).parents(`form`);
        let data = form.serialize();

        $.ajax({
            type: "POST",
            url: geomify.ajax_url,
            data:
                data +
                `&nonce=${geomify.save_ac_info_nonce}&action=save_ac_info&package=${package}`,
            dataType: `JSON`,
            success: function (response) {
                console.log(response);
                if (response.success) {
                    geomifyMessage(response.data.msg);
                } else {
                    geomifyMessage(response.data.msg, "failed");
                }
            },
        });
    });
}

function upgradeForm() {
    let $ = jQuery;

    $(`.upgrade-facilitator`).on(`click`, function (e) {
        upgradeFormThroughAjax(`facilitator`);
    });

    $(`.upgrade-creator`).on(`click`, function (ee) {
        upgradeFormThroughAjax(`creator`);
    });

    $(`.upgrade-basic, .start-basic`).on(`click`, function (e) {
        if ($(this).find(`.basic-unlocked`).length > 0) {
            return;
        }
        upgradeFormThroughAjax("basic");
    });
}

function upgradeFormThroughAjax(package_name) {
    let $ = jQuery;

    $.ajax({
        type: "POST",
        url: geomify.ajax_url,
        data: {
            action: `start_basic_form`,
            nonce: geomify.start_basic_form_nonce,
            package_name,
        },
        dataType: "JSON",
        success: function (response) {
            console.log(response);
            if (response.success) {
                lightBox(response.data.form);
            } else {
                geomifyMessage(response.data.msg, `failed`);
            }
        },
    });
    // let $ = jQuery;
    // $.ajax({
    //     type: "POST",
    //     url: geomify.ajax_url,
    //     data: {
    //         action: `upgrade_license_page`,
    //         nonce: geomify.upgrade_license_page_nonce,
    //         package_name,
    //     },
    //     dataType: "JSON",
    //     success: function (response) {
    //         console.log(response);
    //         if (response.success) {
    //             // $(`.upgrade-panel-${package_name}`).html(
    //             //     `<div class="package-upgrade"><h1>Upgraded</h1></div>`
    //             // );
    //             lightBox(response.data.form);
    //         } else {
    //             geomifyMessage(response.data.msg, `failed`);
    //         }
    //     },
    // });
}

function fillUpUpgraded() {
    let $ = jQuery;

    if (geomify.is_logged_in && geomify.subscriptions.length > 0) {
        if (geomify.subscriptions.free) {
        }

        if (geomify.subscriptions.basic) {
        }

        if (geomify.subscriptions.facilitator) {
            $(`.upgrade-panel-facilitator`).html(`<h1>Upgraded</h1>`);
        }

        if (geomify.subscriptions.creator) {
            $(`.upgrade-panel-creator`).html(`<h1>Upgraded</h1>`);
        }

        if (geomify.subscriptions.enterprise) {
            $(`.upgrade-panel-enterprise`).html(`<h1>Upgraded</h1>`);
        }
    }
}

function handlePayment() {
    let $ = jQuery;
    let items = $(`.payment-method-list .method-item`);
    let options = $(`.method-option`);
    let payment_card = $(`.payment-form`);
    let upgradeForm = $(`.upgrade-form`);

    items.on(`click`, function (e) {
        if ($(this).hasClass(`active-item`)) {
            return;
        }

        if (options.eq($(this).index()).html().trim().length == 0) {
            alert(`Not available!`);
            return;
        }

        $(`.payment-method-list .active-item`).toggleClass(`active-item`);
        $(`.method-option.active-item`).toggleClass(`active-item`);

        $(this).toggleClass(`active-item`);
        options.eq($(this).index()).toggleClass(`active-item`);
    });

    payment_card.on(`submit`, function (e) {
        e.preventDefault();

        let self = $(this);
        let data = self.serialize();
        data += `&action=stripe_payment&nonce=${geomify.stripe_payment_nonce}`;
        let package_name = $(`#package_name`).val();

        $.ajax({
            type: "POST",
            url: geomify.ajax_url,
            data,
            dataType: "JSON",
            success: function (response) {
                if (response.success) {
                    if (package_name == `basic`) {
                        $(`.upgrade-basic`).html(
                            `<i class="fas fa-lock-open"></i> BASIC <span class="blue-text">UNCLOKED</span>`
                        );
                        return;
                    }
                    $(`.pay-section`).html(response.data.page);
                } else {
                    geomifyMessage(response.data.msg, `failed`);
                }
            },
        });
    });

    upgradeForm.on(`submit`, function (e) {
        e.preventDefault();

        let self = $(this);
        let data = self.serialize();
        data += `&action=stripe_upgrade&nonce=${geomify.stripe_upgrade_nonce}`;
        let package_name = $(`#package_name`).val();

        $.ajax({
            type: "POST",
            url: geomify.ajax_url,
            data,
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                if (response.success) {
                    if (package_name == `basic`) {
                        // $(`.upgrade-basic`).html(
                        //     `<i class="fas fa-lock-open"></i> BASIC <span class="blue-text">UNCLOKED</span>`
                        // );
                        window.location.reload();
                        return;
                    }
                    $(`.pay-section`).html(response.data.page);
                } else {
                    geomifyMessage(response.data.msg, `failed`);
                }
            },
        });
    });

    $(`.cancel-upgrade`).on(`click`, function (e) {
        hideLightbox();
    });
}

function handleProjectViews() {
    let $ = jQuery;
    let items = $(`.pv-tab-key`);
    let tabs = $(`.tab-item`);
    let titles = $(`.pv-titles .title-item`);

    items.on(`click`, function (e) {
        if (
            $(this).hasClass(`active-item`) ||
            $(this).find(`.upgrade-not-complete`).length > 0
        ) {
            return;
        }
        $(`.pv-tab-key.active-item`).toggleClass(`active-item`);
        $(`.tab-item.active-item`).toggleClass(`active-item`);
        $(`.pv-titles .title-item.active-item`).toggleClass(`active-item`);

        $(this).toggleClass(`active-item`);
        tabs.eq($(this).index()).toggleClass(`active-item`);
        titles.eq($(this).index()).toggleClass(`active-item`);
    });
}

function handleFileUpload() {
    let $ = jQuery;
    let parent = $(`.file-upload-section`);
    let tabs = parent.find(`.gtab-item`);
    let nextBtn = $(`.file-upload-submit-btn`);
    let keys = parent.find(`.key-item`);
    let startBtn = parent.find(`.start-file-upload-session`);
    let start = 0;

    startBtn.on(`click`, function (e) {
        tabs.eq(0).toggleClass(`active-item`);
        keys.eq(0).toggleClass(`active-item`);
        $(`.file-description`).remove();
        $(this).remove();
    });

    $(`.file-upload-submit-btn`).on(`click`, function (e) {
        // e.preventDefault();

        let currentIndex = start;
        let nextIndex = currentIndex + 1;

        if (geomifyValidateFields($(this).parents("form"), "red") == false) {
            return;
        }

        if (nextIndex == 3) {
            return;
        }

        if (nextIndex == 4) {
            return;
        }

        // nextBtn.eq(0).css({ "background-color": `red` });
        if (tabs.eq(currentIndex).find(`form`).length == 0) {
            tabs.eq(nextIndex).toggleClass(`active-item`);
            tabs.eq(nextIndex - 1).toggleClass(`active-item`);
            keys.eq(nextIndex).toggleClass(`active-item`);
        } else {
            tabs.eq(nextIndex).toggleClass(`active-item`);
            tabs.eq(nextIndex - 1).toggleClass(`active-item`);
            keys.eq(nextIndex).toggleClass(`active-item`);
        }
        start = nextIndex;
        gTabIn = nextIndex;
    });
}

function getQuote() {
    let $ = jQuery;

    $(`.get-quote, .upgrade-enterprise`).on(`click`, function (e) {
        // getShortcode('[geomify-registration step=1]');
        getShortcode(`[elementor-template id=3332]`);
    });
}

function partnerProgramsApply() {
    let $ = jQuery;

    $(`.partner-programs-apply`).on(`click`, function (e) {
        getShortcode("[elementor-template id=3359]");
    });
}

function educationalApply() {
    let $ = jQuery;

    $(`.educational-apply`).on(`click`, function (e) {
        getShortcode("[elementor-template id=3767]");
    });
}

function dragnDropUploader() {
    let $ = jQuery;
    var dropArea = $(".geomify-file-uploader"),
        drpa = document.querySelector(".geomify-file-uploader");
    (button = dropArea.find(".choose-file")),
        (input = document.createElement("input"));
    input.name = "files[]";
    input.id = "files";
    input.type = "file";
    if (drpa == null) {
        return;
    }

    let files_input = $(`#files`);

    let file;

    button.on(`click`, () => {
        input.click();
    });

    files_input.on("change", function () {
        this.files.forEach((file) => {
            addFileToQue(file);
        });
        dropArea.classList.add("active");
    });

    dropArea.on("dragover", (event) => {
        event.preventDefault();
        dropArea.addClass(`active`);
        // dropArea.classList.add("active");
    });

    dropArea.on("dragleave", () => {
        dropArea.removeClass(`active`);
        // dropArea.classList.remove("active");
    });

    drpa.drop = (event) => {
        event.preventDefault();
        event.dataTransfer.files.forEach((file) => {
            addFileToQue(file);
        });
        dropArea.classList.remove("active");
    };
}

function addFileToQue(file) {
    let $ = jQuery;
    let queHolder = $(`.file-que`);
    let fileName =
        file.name.length > 12
            ? file.name.slice(0, 8) +
              "..." +
              file.name.split(".")[file.name.split(".").length - 1]
            : file.name;

    queHolder.append(`
    <div class="que-row">
        <div class="que-col">
            FILE: ${fileName}
        </div>
        <div class="que-col">
            <div class="prgs-holder">
                <div class="prgs-row">
                    <div class="prgs-col">
                        Upload progress
                    </div>
                    <div class="prgs-col prc-col">
                            <div class="upload-prc">0</div>%
                    </div>
                </div>
                <div class="prgs-row">
                    <div class="prgs-col">
                        <div class="prgs-prc">
                            <div class="current-prc"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="que-col">
            <div class="dlt-que"><i class="fas fa-trash-alt"></i></div>
        </div>
    </div>
`);

    geomifyUserFilesArray.push(file);

    $(`.dlt-que i`)
        .unbind(`click`)
        .on(`click`, function (e) {
            if (confirm(`Are you sure to delete this file`)) {
                $(this)
                    .parents(`.que-row`)
                    .css({
                        backgroundColor: `red`,
                    })
                    .slideUp(500, function (e) {
                        $(this).remove();
                    });

                geomifyUserFilesArray[$(this).parents(`.que-row`).index()] =
                    undefined;
            }
        });
}

function uploadUserFile() {
    let $ = jQuery;
    let parent = $(`.file-upload-section`);
    let btn = parent.find(`.file-upload-submit-btn.final-submission`);
    let forms = $(`.file-upload-section form`);
    let formData = ``;

    btn.on(`click`, function (e) {
        e.preventDefault();

        if ($(`#i_hearby`).prop("checked") == false) {
            alert(`Please accept agreement`);
            return;
        }

        $(this).unbind(`click`);

        for (let i = 0; i < forms.length; i++) {
            let dt = forms.eq(i).serialize();
            formData += dt.length > 0 ? dt + "&" : dt;
        }

        formData += `action=file_info_submit&nonce=file_info_submit_nonce`;

        $.ajax({
            type: "POST",
            url: geomify.ajax_url,
            data: formData,
            dataType: "JSON",
            success: function (response) {
                if (response.success) {
                    beginFileUpload();
                }
            },
            error: function (res) {},
            complete: function (res) {},
        });
    });
}

function beginFileUpload() {
    let $ = jQuery;

    geomifyUserFilesArray.forEach((file, index) => {
        if (file == undefined) {
            return;
        }

        let data = new FormData();
        let row = $(`.que-row`).eq(index);
        let prcVisual = row.find(`.current-prc`);
        let dltBtn = row.find(`i`);
        let prcText = row.find(`.upload-prc`);

        data.append("file", file);
        data.append("action", "upload_geo_files");
        data.append("nonce", geomify.upload_geo_files_nonce);

        $.ajax({
            xhr: function () {
                var xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener(
                    "progress",
                    function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            prcVisual.css({
                                width: percentComplete + `%`,
                            });
                            prcText.text(percentComplete);
                        }
                    },
                    false
                );

                return xhr;
            },
            type: "POST",
            url: geomify.ajax_url,
            data,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success) {
                    dltBtn.remove();
                } else {
                    geomifyMessage(response.data.msg, `failed`);
                }

                if (index == geomifyUserFilesArray.length - 1) {
                    let tparent = $(`.file-upload-section`);
                    let tabs = tparent.find(`.gtab-item`);
                    let keys = tparent.find(`.key-item`);

                    let currentIndex = gTabIn;
                    let nextIndex = currentIndex + 1;

                    if (tabs.eq(currentIndex).find(`form`).length == 0) {
                        tabs.eq(nextIndex).toggleClass(`active-item`);
                        tabs.eq(nextIndex - 1).toggleClass(`active-item`);
                        keys.eq(nextIndex).toggleClass(`active-item`);
                    } else {
                        tabs.eq(nextIndex).toggleClass(`active-item`);
                        tabs.eq(nextIndex - 1).toggleClass(`active-item`);
                        keys.eq(nextIndex).toggleClass(`active-item`);
                    }
                    gTabIn = nextIndex;
                }
            },
            error: function (res) {},
            complete: function (res) {},
        });
    });
}

function dltPm() {
    let $ = jQuery;

    $(`.dlt-pm`).on(`click`, function (e) {
        if (confirm(`Are you sure to remove this payment method?`) == false) {
            return;
        }
        let self = $(this);
        let parent = self.parents(".billing-method-item");
        let pmId = parent.data("id");

        $.ajax({
            type: "POST",
            url: geomify.ajax_url,
            data: {
                action: `remove_pm`,
                nonce: geomify.remove_pm_nonce,
                id: pmId,
            },
            dataType: "JSON",
            success: function (response) {
                if (response.success) {
                    parent
                        .css({
                            backgroundColor: `red`,
                        })
                        .slideUp(500, function (e) {
                            $(this).remove();
                        });
                } else {
                    geomifyMessage(response.data.msg, `failed`);
                }
            },
        });
    });
}

function editPv() {
    let $ = jQuery;

    $(`.edit-pv`).on(`click`, function (e) {
        e.preventDefault();

        let parent = $(this).parents(`a`);
        let id = parent.data(`id`);

        $.ajax({
            type: "POST",
            url: geomify.ajax_url,
            data: {
                action: `edit_pv_form`,
                id,
            },
            dataType: "JSON",
            success: function (response) {
                if (response.success) {
                    $(`body`).append(response.data.form);
                }
            },
        });
    });
}

function dltPv() {
    let $ = jQuery;

    $(`.dlt-pv`).on(`click`, function (e) {
        e.preventDefault();

        if (confirm(`Are you sure to delete this item?`) == false) {
            return;
        }

        let parent = $(this).parents(`a`);
        let id = parent.data(`id`);

        $.ajax({
            type: "POST",
            url: geomify.ajax_url,
            data: {
                action: `dlt_pv`,
                nonce: geomify.dlt_pv_nonce,
                id,
            },
            dataType: `JSON`,
            success: function (response) {
                if (response.success) {
                    parent
                        .css({
                            backgroundColor: `red`,
                        })
                        .slideUp(500, function (e) {
                            parent.remove();
                        });
                } else {
                    geomifyMessage(response.data.msg, `failed`);
                }
            },
        });
    });
}

function startBasicForm() {
    // let $ = jQuery;
    // let btn = $(`.start-basic`);
    // btn.on(`click`, function (e) {
    //     e.preventDefault();
    //     $.ajax({
    //         type: "POST",
    //         url: geomify.ajax_url,
    //         data: {
    //             action: `start_basic_form`,
    //             nonce: geomify.start_basic_form_nonce,
    //         },
    //         dataType: "JSON",
    //         success: function (response) {
    //             console.clear();
    //             console.log(response);
    //             if (response.success) {
    //                 lightBox(response.data.form);
    //             } else {
    //                 geomifyMessage(response.data.msg, `failed`);
    //             }
    //         },
    //     });
    // });
}

function startBasic() {
    let $ = jQuery;
    let parent = $(`.start-basic-holder`);
    let form = parent.find(`form`);

    form.on(`submit`, function (e) {
        e.preventDefault();
        if (geomifyValidateFields(form, `red`) == false) {
            return;
        }

        let data = $(this).serialize();
        data += `&action=start_basic&nonce=${geomify.start_basic_nonce}`;

        $.ajax({
            type: "POST",
            url: geomify.ajax_url,
            data,
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                if (response.success) {
                    parent.html(response.data.page);
                } else {
                    geomifyMessage(response.data.msg, `failed`);
                }
            },
        });
    });
}

function ckConsent() {
    let $ = jQuery;
    let acptBtn = $(`.ck-accept`);
    let prfBtn = $(`.ck-reject`);
    let holder = $(`.ck-holder`);
    let checkCookie = document.cookie.indexOf("CookieBy=Geomify");
    let rows = $(`.ck-row`);

    // alert(checkCookie)

    if (checkCookie == -1) {
        holder.css({
            display: `flex`,
        });
    }

    acptBtn.on(`click`, function (e) {
        document.cookie = "CookieBy=Geomify; max-age=" + 60 * 60 * 24 * 30;
        holder.css({
            display: `none`,
        });
    });

    prfBtn.on(`click`, function (e) {
        rows.eq(0).slideUp(300, function (e) {
            rows.eq(1).show().css({ display: `flex` });
        });
    });
}

function geoLogin() {
    let $ = jQuery;
    let parent = $(`.ul-row`);
    let loginBtn = parent.find(`.login-btn`);
    let startBtn = parent.find(`.start-free-btn`);
    let img = parent.find(`.brand-logo`);

    loginBtn.on(`click`, function (e) {
        e.preventDefault();
        img.addClass(`is-loading`);

        let data = parent.serialize();
        data += `&action=geo_login&nonce=${geomify.geo_login_nonce}`;

        $.ajax({
            type: "POST",
            url: geomify.ajax_url,
            data,
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                if (response.success) {
                    geomifyMessage(response.data.msg);
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    geomifyMessage(response.data.msg, `failed`);
                }
            },
            complete: function (response) {
                img.removeClass(`is-loading`);
            },
        });
    });
}

function geoReset() {
    let $ = jQuery;
    let parent = $(`.ur-row`);
    let resetBtn = parent.find(`.login-btn`);
    let img = parent.find(`.brand-logo`);
    let resetPassBtn = parent.find(`.reset-btn`);

    resetBtn.on(`click`, function (e) {
        e.preventDefault();
        img.addClass(`is-loading`);

        let data = parent.serialize();
        data += `&action=geo_reset&nonce=${geomify.geo_reset_nonce}`;

        $.ajax({
            type: "POST",
            url: geomify.ajax_url,
            data,
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                if (response.success) {
                    geomifyMessage(response.data.msg);
                } else {
                    geomifyMessage(response.data.msg, `failed`);
                }
            },
            complete: function (res) {
                img.removeClass(`is-loading`);
            },
        });
    });

    resetPassBtn.on(`click`, function (e) {
        e.preventDefault();

        img.addClass(`is-loading`);

        let data = parent.serialize();
        data += `&action=geo_pass_reset&nonce=${geomify.geo_pass_reset_nonce}`;

        $.ajax({
            type: "POST",
            url: geomify.ajax_url,
            data,
            dataType: "JSON",
            success: function (response) {
                if (response.success) {
                    geomifyMessage(response.data.msg);

                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    geomifyMessage(response.data.msg, `failed`);
                }
            },
        });
    });
}

function udmHandle() {
    let $ = jQuery;
    let parent = $(`.udm-holder`);
    let toggle = parent.find(`.udm-toggle`);
    let udm = parent.find(`.udm-items`);
    let hideBtn = parent.find(`.hide-udm`);

    toggle.on(`click`, function (e) {
        e.preventDefault();

        udm.toggleClass(`active`);
    });
    hideBtn.on(`click`, function (e) {
        e.preventDefault();

        udm.removeClass(`active`);
    });
}
