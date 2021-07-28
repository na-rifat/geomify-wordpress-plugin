<h1>Geomify - options</h1>
<hr>
<br>
<br>

<form action="#" method="POST" class="geo-options">
    <h3>Stripe settings</h3>
    <table class="form-table">
        <tr>
            <th><label for="stripe_api_key">API key</label></th>
            <td><input type="text" class="regular-text" name="stripe_api_key" id="stripe_api_key"></td>
        </tr>
        <tr>
            <th><label for="stripe_secret_key">Secret key</label></th>
            <td><input type="text" class="regular-text" name="stripe_secret_key" id="stripe_secret_key"></td>
        </tr>
        <tr>
            <th><label for="free_subscription_key">Free subscription key</label></th>
            <td><input type="text" class="regular-text" name="free_subscription_key" id="free_subscription_key"></td>
        </tr>
        <tr>
            <th><label for="basic_subscription_key">Basic subscription key</label></th>
            <td><input type="text" class="regular-text" name="basic_subscription_key" id="basic_subscription_key"></td>
        </tr>
        <tr>
            <th><label for="facilitator_subscription_key">Facilitator subscription key</label></th>
            <td><input type="text" class="regular-text" name="facilitator_subscription_key"
                    id="facilitator_subscription_key"></td>
        </tr>
        <tr>
            <th><label for="creator_subscription_key">Creator subscription key</label></th>
            <td><input type="text" class="regular-text" name="creator_subscription_key" id="creator_subscription_key">
            </td>
        </tr>
        <tr>
            <th><label for="enterprise_subscription_key">Enterprise subscription key</label></th>
            <td><input type="text" class="regular-text" name="enterprise_subscription_key"
                    id="enterprise_subscription_key"></td>
        </tr>
        <tr>
            <th></th>
            <td><input type="submit" value="Save" class="geomify-form-submit-btn save-geo-options"></td>
        </tr>
    </table>
</form>


<?php
    // echo sizeof((\geomify\Processor\User::stripe_invoices()));
//  print_r(\geomify\Processor\User::stripe_invoices());
?>