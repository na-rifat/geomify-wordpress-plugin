<?php
    $fields = \geomify\Schema\Schema::get( 'geo_files_info' );
    $fields = \geomify\Processor\Processor::add_name_to_inputs( $fields );
    $input  = new \geomify\Processor\Input();
    $user = new \geomify\Processor\User();

    $fields['first_name']['value'] = $user::get_meta('first_name');
    $fields['last_name']['value'] = $user::get_meta('last_name');
    $fields['mobile']['value'] = $user::get_meta('mobile');
    $fields['user_email']['value'] = $user::email();
    $fields['company']['value'] = $user::get_meta('company');
    $fields['address1']['value'] = $user::get_meta('address1');
    $fields['address2']['value'] = $user::get_meta('company');
    $fields['zip']['value'] = $user::get_meta('zip');
    $fields['city']['value'] = $user::get_meta('city');
    $fields['country']['value'] = $user::get_meta('country');
?>

<div class="file-upload-form">
    <h3>Verify your contact details</h3>
    <p>Your current account information</p>
    <form action="#">
        <?php
            $input::create_field_pair( $fields['first_name'], $fields['last_name'] );
            $input::create_field_pair( $fields['mobile'], $fields['user_email'] );
            $input::create_field( $fields['company'] );
            $input::create_field( $fields['address1'] );
            $input::create_field( $fields['address2'] );
            $input::create_field_pair( $fields['zip'], $fields['city'] );
            $input::create_field( $fields['country'] );
        ?>
        <div class="geomify-form-submit-btn file-upload-submit-btn save-ac-info"> <i class="fas fa-sign-in-alt"></i>SAVE & NEXT</div>
    </form>
</div>