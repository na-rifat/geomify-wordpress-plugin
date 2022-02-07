<?php \geomify\Processor\User::is_logged() or exit; defined('ABSPATH') or exit; ?>

<?php
    $fields = \geomify\Schema\Schema::get( 'profile_basic' );
    $fields = \geomify\Processor\Processor::add_name_to_inputs($fields);
    $fields = \geomify\Processor\Processor::add_values_to_schema($fields, \geomify\Processor\Processor::get_user_package_info('basic'));

    $input         = new \geomify\Processor\Input();
    // foreach ( $fields as $key => $props ) {
    //     // $fields
    // }
    $domain                        = GTD;
    $fields['new_password'] = [
        'label'       => __( 'New password', $domain ),
        'placeholder' => __( 'New password', $domain ),
        'type'        => 'passaword',
    ];
    $fields['confirm_password'] = [
        'label'       => __( 'Confirm password', $domain ),
        'placeholder' => __( 'Confirm password', $domain ),
        'type'        => 'password',
    ];    
?>

<div class="profile-section" data-profile_package="basic">
    <div class="profile-row">
        <form action="#" method="POST" >
            <div class="profile-col">
                <p>User & Password</p>
                <?php $input::create_field_pair( $fields['user_email'], $fields['new_password'] )?>
                <?php $input::create_field_pair( $fields['personal_code'], $fields['confirm_password'] )?>
            </div>
            <div class="profile-col button-col">
                <div class="geomify-form-submit-btn save-ac-info"><i class="fas fa-file-export"></i>SAVE</div>
            </div>
        </form>
    </div>
    <div class="profile-row">
        <form action="#" method="POST">
            <div class="profile-col">
                <h2>BASIC and License Upgrade Information</h2>
                <p>Your current account information</p>
                <?php $input::create_field_pair( $fields['first_name'], $fields['last_name'] )?>
                <?php $input::create_field_pair( $fields['mobile'], $fields['phone'] )?>
                <?php $input::create_field( $fields['company'] )?>
                <?php $input::create_field( $fields['address1'] )?>
                <?php $input::create_field( $fields['address2'] )?>
                <?php $input::create_field_pair( $fields['zip'], $fields['city'] )?>
                <?php $input::create_field( $fields['country'] )?>
            </div>
            <div class="profile-col button-col">
                <div class="geomify-form-submit-btn save-ac-info"><i class="fas fa-file-export"></i>SAVE</div>
            </div>
        </form>
    </div>
    <div class="profile-row">
        <form action="#" method="POST">
            <div class="profile-col">
                <p>Enter your invoice information</p>
                <?php $input::create_field_pair( $fields['vat_number'], $fields['company_number'] )?>
                <?php $input::create_field_pair( $fields['ean_number'], $fields['invoice_email'] )?>
            </div>
            <div class="profile-col button-col">
                <div class="geomify-form-submit-btn save-ac-info"><i class="fas fa-file-export"></i>SAVE</div>
            </div>
        </form>
    </div>

</div>