<?php
    $fields = \geomify\Schema\Schema::get( 'tutorials' );
    $input  = new \geomify\Processor\Input();

    $fields['file'] = [
        'label'     => __( 'Choose file', GTD ),
        'type'      => 'file',
        'use_label' => true,
        'required'  => true,
    ];

    $fields = \geomify\Processor\Processor::assign_names_to_schema($fields);

?>

<div class="geomify-form-holder">
    <form action="#" method="POST" class="white-form" id="new_tutorial_form">
        <?php $input::create_field( $fields['caption'] )?>
        <?php $input::create_field( $fields['license'] )?>
        <?php $input::create_field( $fields['file'] )?>
        <br>
        <input type="submit" value="Add" class="geomify-form-submit-btn new-tutorial">
        <br>
        <br>
        <div class="progress-loader">
            <div class="progress-count"></div>
            <div class="progress-count-text"></div>
        </div>
    </form>
</div>