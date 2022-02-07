<?php \geomify\Processor\User::is_logged() or exit;
defined('ABSPATH') or exit; ?>

<?php
$fields = \geomify\Schema\Schema::get('profile_basic');
$fields = \geomify\Processor\Processor::add_name_to_inputs($fields);
$fields = \geomify\Processor\Processor::add_values_to_schema($fields, \geomify\Processor\Processor::get_user_package_info('basic'));
$user   = new \geomify\Processor\User();

$input = new \geomify\Processor\Input();

$domain                 = GTD;
$fields['new_password'] = [
    'label'       => __('New password', $domain),
    'placeholder' => __('New password', $domain),
    'type'        => 'passaword',
];
$fields['confirm_password'] = [
    'label'       => __('Confirm password', $domain),
    'placeholder' => __('Confirm password', $domain),
    'type'        => 'password',
];

$fields['first_name']['value']     = $user::get_meta('first_name');
$fields['last_name']['value']      = $user::get_meta('last_name');
$fields['user_email']['value']     = $user::email();
$fields['personal_code']['value']  = $user::get_meta('personal_code');
$fields['address1']['value']       = $user::get_meta('address1');
$fields['address2']['value']       = $user::get_meta('address2');
$fields['city']['value']           = $user::get_meta('city');
$fields['company']['value']        = $user::get_meta('company');
$fields['country']['value']        = $user::get_meta('country');
$fields['mobile']['value']         = $user::get_meta('mobile');
$fields['zip']['value']            = $user::get_meta('zip');
$fields['phone']['value']          = $user::get_meta('phone');
$fields['vat_number']['value']     = $user::get_meta('vat_number');
$fields['company_number']['value'] = $user::get_meta('company_number');
$fields['ean_number']['value']     = $user::get_meta('ean_number');
$fields['invoice_email']['value']  = $user::get_meta('invoice_email');

// var_dump( $fields['country']['value'] );

?>

<div class="gtab-holder profile-section">
    <div class="gtab-header bottom-line">
        <div class="header-item">
            <h2>Profile information</h2>
            <p>Your current account information</p>
        </div>
        <div class="header-item">

        </div>
    </div>
    <div class="gtab-toolbar">
    </div>
    <div class="gtab-body">
        <div class="profile-row">
            <form action="#" method="POST">
                <div class="profile-col">
                    <h2><?php echo strtoupper($user::current_subscription()) ?> user information</h2>
                    <?php $input::create_field_pair($fields['first_name'], $fields['last_name']) ?>
                    <?php $input::create_field($fields['user_email']) ?>
                    <?php $user::current_subscription() != 'free' or $input::create_field($fields['country']) ?>
                    <?php $input::create_field_pair($fields['new_password'], $fields['confirm_password']) ?>
                </div>
                <div class="profile-col button-col">
                    <div class="geomify-form-submit-btn save-ac-info"><i class="fas fa-file-export"></i>SAVE</div>
                </div>
            </form>
        </div>
        <?php
        if ($user::have_permit('basic')) {
        ?>
        <div class="profile-row">
            <form action="#" method="POST">
                <div class="profile-col">
                    <h2>Company information (Required)</h2>
                    <?php $input::create_field_pair($fields['mobile'], $fields['phone']) ?>
                    <?php $input::create_field($fields['company']) ?>
                    <?php $input::create_field($fields['address1']) ?>
                    <?php $input::create_field($fields['address2']) ?>
                    <?php $input::create_field_pair($fields['zip'], $fields['city']) ?>
                    <?php $user::current_subscription() == 'free' or $input::create_field($fields['country']) ?>
                </div>
                <div class="profile-col button-col">
                    <div class="geomify-form-submit-btn save-ac-info"><i class="fas fa-file-export"></i>SAVE</div>
                </div>
            </form>
        </div>
        <div class="profile-row">
            <form action="#" method="POST">
                <div class="profile-col">
                    <h2>Invoice information (Required)</h2>
                    <?php
                        $input::create_field_pair($fields['vat_number'], $fields['company_number']);
                        $input::create_field_pair($fields['ean_number'], $fields['invoice_email']);
                        ?>
                </div>
                <div class="profile-col button-col">
                    <div class="geomify-form-submit-btn save-ac-info"><i class="fas fa-file-export"></i>SAVE</div>
                </div>
            </form>
        </div>
        <?php
        }
        ?>
    </div>
</div>