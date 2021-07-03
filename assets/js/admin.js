(function ($) {
    $(document).ready(() => {
        newTutorialPage();
        getTutorials();
    });
})(jQuery);

function newTutorialPage() {
    let $ = jQuery;

    $(`.new-tutorial-page`).on(`click`, function (e) {
        $.ajax({
            type: "POST",
            url: geomify.ajax_url,
            data: {
                action: `new_tutorial_page`,
                nonce: geomify.new_tutorial_page_nonce,
            },
            dataType: `JSON`,
            success: function (response) {
                if (response.success) {
                    lightBox(response.data.form);
                    newTutorial();
                } else {
                }
            },
            error: function (res) {},
            complete: function (res) {},
        });
    });
}

function newTutorial() {
    let $ = jQuery;

    $(`.new-tutorial`).on(`click`, function (e) {
        e.preventDefault();

        if (geomifyValidateFields(`#new_tutorial_form`, `red`) == false) {
            return;
        }

        let btn = $(this);
        let loader = btn.parent().find(`.progress-loader`);
        loader.css({ display: `block` });

        let data = new FormData(document.getElementById(`new_tutorial_form`));
        data.append(`nonce`, geomify.new_tutorial_nonce);
        data.append(`action`, `new_tutorial`);

        jQuery.ajax({
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener(
                    "progress",
                    function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete =
                                (evt.loaded / evt.total) * 100;
                            loaderProgress(loader, percentComplete);
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
                    $(`.tutorials-list-holder`).html(response.data.list);
                    geomifyMessage(response.data.msg);
                } else {
                }
            },
            error: function (res) {
                geomifyMessage(
                    `There was an error adding new tutorial`,
                    "failed"
                );
            },
            complete: function (res) {
                hideLightbox();
            },
        });
    });
}

function getTutorials() {
    let $ = jQuery;

    $.ajax({
        type: "POST",
        url: geomify.ajax_url,
        data: {
            action: `get_admin_tutorials`,
            nonce: geomify.get_admin_tutorials_nonce,
        },
        dataType: "JSON",
        success: function (response) {
            if (response.success) {
                $(`.tutorials-list-holder`).html(response.data.list);
            } else {
                geomifyMessage(response.data.msg, "failed");
            }
        },
    });
}

function deleteTutorial() {
    let $ = jQuery;

    $(`.geomify-delete-turoial`).on(`click`, function (e) {
        e.preventDefault();
        let parent = $(this).parents(`tr`);

        if (!confirm(`Are you sure to delete this tutorial?`)) {
            return;
        }

        $.ajax({
            type: "POST",
            url: geomify.ajax_url,
            data: {
                action: `delete_tutorial`,
                nonce: geomify.delete_tutorial_nonce,
                id: parent.data(`id`),
            },
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                if (response.success) {
                    parent
                        .css({
                            backgroundColor: `red`,
                        })
                        .hide(500, function (e) {
                            parent.remove();
                        });
                } else {
                    geomifyMessage(response.data.msg, `failed`);
                }
            },
        });
    });
}

// function editTutorialPage() {
//     let $ = jQuery;

//     $(`.geomify-edit-tuorial`).on(`click`, function (e) {
//         e.preventDefault();

//         let parent = $(this).parents(`tr`);
//         let id = parent.data(`id`);

//         $.ajax({
//             type: "POST",
//             url: geomify.ajax_url,
//             data: {
//                 action: `edit_tutorial`,
//                 nonce: geomify.edit_tutorial_nonce,
//                 id,
//             },
//             dataType: "JSON",
//             success: function (response) {},
//         });
//     });
// }

// function editTutorial() {
//     let $ = jQuery;

//     $(`.submit-edit-tutorial`).on(`click`, function (e) {
//         e.preventDefault();

//         $.ajax({
//             type: "POST",
//             url: geomify.ajax_url,
//             data: ,
//             dataType: "dataType",
//             success: function (response) {

//             }
//         });
//     });
// }
