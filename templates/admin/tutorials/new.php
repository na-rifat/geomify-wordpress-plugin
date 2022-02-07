<?php \geomify\Processor\User::is_logged() or exit; defined('ABSPATH') or exit; ?>

<?php
    $fields = \geomify\Schema\Schema::get( 'tutorials' );
    $input  = new \geomify\Processor\Input();

    // $fields['file'] = [
    //     'label'     => __( 'Choose file', GTD ),
    //     'type'      => 'file',
    //     'use_label' => true,
    //     'required'  => true,
    // ];

    $fields = \geomify\Processor\Processor::assign_names_to_schema($fields);

?>
<div class="new-pv-holder">
    <div class="new-project-view">
        <div class="new-pv-close-button">
            x
        </div>
        <div class="new-pv-header">
            <div class="new-pv-col">
                <img src="<?php geomify_brand_logo()?>" alt="<?php _e( 'Geomify brand logo', GTD )?>">
            </div>
            <div class="new-pv-col">
                <h5>GEOMIFY</h3>
                    <h2>ADMIN</h2>
                    <br>
                    <h2>Tutorials</h2>
                    <h5>Add New Video Tutorial</h5>
            </div>
        </div>
        <div class="new-pv-body">
            <div class="geomify-form-holder">

                <form action="#" method="POST" class="white-form" id="new_tutorial_form">
                    <?php $input::create_field( $fields['caption'] )?>
                    <?php $input::create_field( $fields['file_url'] )?>
                    <?php $input::create_field( $fields['license'] )?>
                    <br>
                    <input type="submit" value="SAVE & ADD TO VIDEO TUTORIAL LIST" class="geomify-form-submit-btn new-tutorial">
                    <br>
                    <br>
                    <div class="progress-loader">
                        <div class="progress-count"></div>
                        <div class="progress-count-text"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    (function($) {
        $(`.new-pv-close-button`).on(`click`, function(e) {
            $(`.new-pv-holder`).remove();
        });
        // Submission
        $(`.new-pv-submit`).on(`click`, function(e) {
            e.preventDefault();

            let parent = $(`.new-project-view`);

            if (geomifyValidateFields(parent, `red`) === false) {
                return;
            }

            parent.append(
                `<div class="brand-loading-invert"><img src="${geomify.logo_url}" /></div>`
            );

            $(`.brand-loading-invert`).css({
                backgroundColor: parent.css(`background-color`),
            });

            let data = parent.find(`form`).serialize();
            data += `&action=new_pv`;
            data += `&nonce=${geomify.new_pv_nonce}`;

            $.ajax({
                type: "POST",
                url: geomify.ajax_url,
                data,
                dataType: "JSON",
                success: function(response) {
                    if (response.success) {
                        let formView = $(`.new-pv-holder`);
                        formView.find(`.new-project-view`).hide(300, function(e) {
                            formView.remove();
                            geomifyMessage(response.data.message);
                            getPv();
                        });
                    }
                },
                error: function(response) {},
                complete: function(response) {
                    parent.find(`.brand-loading-invert`).remove();
                },
            });
        });
    })(jQuery)
    </script>
</div>