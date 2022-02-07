(function ($) {
    $(document).ready(() => {  
        getTutorials();
        save_geo_options();
        dltGeoFile();
        viewGeoFile();
    });
})(jQuery);


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

function save_geo_options() {
    let $ = jQuery;
    let form = $(`.geo-options`);

    form.on(`submit`, function (e) {
        e.preventDefault();

        let data = $(this).serialize();

        data += `&action=save_geo_options&nonce=${geomify.save_geo_options_nonce}`;

        $.ajax({
            type: "POST",
            url: geomify.ajax_url,
            data,
            dataType: "JSON",
            success: function (response) {
                if (response.success) {
                    geomifyMessage(response.data.msg);
                } else {
                    geomifyMessage(response.data.msg, `failed`);
                }
            },
        });
    });
}

function dltGeoFile() {
    let $ = jQuery;
    btn = $(`.dlt-geo-file`);

    btn.on(`click`, function (e) {
        e.preventDefault();

        if (confirm(`Confirm delete?`) == false) {
            return;
        }

        let self = $(this);

        let data = {
            action: `dlt_geo_file`,
            nonce: geomify.dlt_geo_file_nonce,
            id: $(this).data(`id`),
        };

        $.ajax({
            type: "POST",
            url: geomify.ajax_url,
            data,
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                if (response.success) {
                    self.parents("tr")
                        .css({
                            backgroundColor: `red`,
                        })
                        .slideUp(500, function (e) {
                            self.parents(`tr`).remove();
                        });
                } else {
                    geomifyMessage(response.data.msg, `failed`);
                }
            },
        });
    });
}

function viewGeoFile() {
    let $ = jQuery;

    let btn = $(`.view-geo-file`);

    btn.on(`click`, function (e) {
        e.preventDefault();

        let data = {
            action: `view_geo_file`,
            nonce: geomify.view_geo_file_nonce,
            id: $(this).data(`id`),
        };

        $.ajax({
            type: "POST",
            url: geomify.ajax_url,
            data,
            dataType: "JSON",
            success: function (response) {
                if (response.success) {
                    lightBox(response.data.view);
                } else {
                    geomifyMessage(response.data.msg, `failed`);
                }
            },
        });
    });
}
