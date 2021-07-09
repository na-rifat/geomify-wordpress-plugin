<?php
    $schema = \geomify\Schema\Schema::get( 'project_views' );
    $schema = \geomify\Processor\Processor::add_name_to_inputs( $schema );
    $schema = \geomify\Processor\Input::add_global_props( $schema, [
        'required' => true,
    ] );
    $form = new \geomify\Processor\Form();
    // $values = \geomify\Schema\CRUD::retrieve( 'project_views', $_POST['id'] );
    $values = \geomify\Schema\CRUD::get_row( 'project_views', $_POST['id'] );
    $schema = \geomify\Processor\Processor::add_values_to_schema( $schema, $values );

    // var_dump( $schema );

    $form->create_field( $schema['project_view_name'] );
    $form->create_field( $schema['description'] );
    $form->create_field( $schema['url'] );
    $form->create_field( $schema['industry'] );
    $form->create_field( $schema['country'] );
    $form->create_field(
        [
            'name'  => 'submit',
            'type'  => 'button',
            'value' => __( 'Update', $domain ),
            'class' => ['new-pv-update'],
        ]
    );

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
                    <h2>Project view</h2>
                    <h5>Add New Project View</h5>
            </div>
        </div>
        <div class="new-pv-body">
            <?php $form->_get()?>
        </div>
    </div>
    <script>
    (function($) {
        $(`.new-pv-close-button`).on(`click`, function(e) {
            $(`.new-pv-holder`).remove();
        });
        // Submission
        $(`.new-pv-update`).on(`click`, function(e) {
            e.preventDefault();

            let parent = $(`.new-project-view`);

            if(geomifyValidateFields(parent, `red`) === false){
                return;
            }

            parent.append(
                `<div class="brand-loading-invert"><img src="${geomify.logo_url}" /></div>`
            );

            $(`.brand-loading-invert`).css({
                backgroundColor: parent.css(`background-color`),
            });

            let data = parent.find(`form`).serialize();
            data += '&id=<?php echo $_POST['id'] ?>'
            data += `&action=update_pv`;
            data += `&nonce=${geomify.update_pv_nonce}`;

            $.ajax({
                type: "POST",
                url: geomify.ajax_url,
                data,
                dataType: "JSON",
                success: function(response) {
                    console.log(response)
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