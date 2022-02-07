<?php

use geomify\geomify;

\geomify\Processor\User::is_logged() or exit;
defined( 'ABSPATH' ) or exit;?>

<h1>Geomify - options</h1>
<hr>
<br>
<br>

<form action="#" method="POST" class="geo-options">
    <h3>Stripe settings</h3>
    <table class="form-table">
        <tr>
            <th><label for="stripe_api_key">API key</label></th>
            <td><input type="text" class="regular-text" name="stripe_api_key" id="stripe_api_key"
                    value="<?php echo get_option( 'stripe_api_key' ) ?>"></td>
        </tr>
        <tr>
            <th><label for="stripe_secret_key">Secret key</label></th>
            <td><input type="text" class="regular-text" name="stripe_secret_key" id="stripe_secret_key"
                    value="<?php echo get_option( 'stripe_secret_key' ) ?>"></td>
        </tr>
        <tr>
            <th><label for="free_subscription_key">Free subscription key</label></th>
            <td><input type="text" class="regular-text" name="free_subscription_key" id="free_subscription_key"
                    value="<?php echo get_option( 'free_subscription_key' ) ?>"></td>
        </tr>
        <tr>
            <th><label for="basic_subscription_key">Basic subscription key</label></th>
            <td><input type="text" class="regular-text" name="basic_subscription_key" id="basic_subscription_key"
                    value="<?php echo get_option( 'basic_subscription_key' ) ?>"></td>
        </tr>
        <tr>
            <th><label for="facilitator_subscription_key">Facilitator subscription key</label></th>
            <td><input type="text" class="regular-text" name="facilitator_subscription_key"
                    id="facilitator_subscription_key"
                    value="<?php echo get_option( 'facilitator_subscription_key' ) ?>"></td>
        </tr>
        <tr>
            <th><label for="creator_subscription_key">Creator subscription key</label></th>
            <td><input type="text" class="regular-text" name="creator_subscription_key" id="creator_subscription_key"
                    value="<?php echo get_option( 'creator_subscription_key' ) ?>">
            </td>
        </tr>
        <tr>
            <th><label for="enterprise_subscription_key">Enterprise subscription key</label></th>
            <td><input type="text" class="regular-text" name="enterprise_subscription_key"
                    id="enterprise_subscription_key" value="<?php echo get_option( 'enterprise_subscription_key' ) ?>">
            </td>
        </tr>
        <tr>
            <th></th>
            <td><input type="submit" value="Save" class="geomify-form-submit-btn save-geo-options"></td>
        </tr>
    </table>
</form>


<?php
//     var_dump( \geomify\Processor\Geomify_stripe::package( 'basic' ) );

//     echo \geomify\Processor\Geomify_stripe::subscription()->update(
//         \geomify\Processor\User::stripe_subscription_id(),
//         [
//             // 'items'             => [
//             //     [
//             //         'id'    => \geomify\Processor\User::stripe_subscription_id(),
//             //         'price' => \geomify\Processor\Geomify_stripe::package( 'basic' ),
//             //     ],
//             // ],
//             'default_tax_rates' => \geomify\Processor\Processor::country_code( \geomify\Processor\User::get_meta( 'country' ) ) == 'DK' ? \geomify\Processor\Geomify_stripe::tax_rates : '',
//             'automatic_tax'     => [
//                 'enabled' => false,
//             ],
//         ]
// );
// var_dump(  );sdfsdf

// \geomify\Processor\Geomify_stripe::create_subscription(
//     \geomify\Processor\User::stripe_customer_id(),
//     \geomify\Processor\Geomify_stripe::package('basic')
// );
var_dump(\geomify\Processor\User::get_meta('vat'));