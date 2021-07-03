<?php
    $fields = \geomify\Schema\Schema::get( 'file_upload_description' );
    $fields = \geomify\Processor\Processor::add_name_to_inputs( $fields );
    $input  = new \geomify\Processor\Input();
?>

<div class="file-upload-form">
    <h3>Describe your data</h3>
    <p>Data tpye, location and public value</p>
    <form action="#">
        <?php
            $input::create_field( $fields['data_type'] );
            $input::create_field( $fields['country'] );
            $input::create_field( $fields['location'] );
            $input::create_field( $fields['description'] );
        ?>
        <div class="geomify-form-submit-btn file-upload-submit-btn"> <i class="fas fa-sign-in-alt"></i>SAVE & NEXT</div>
    </form>
</div>