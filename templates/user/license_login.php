<?php
    $fields = \geomify\Schema\Schema::get( 'license_login' );
    $fields = \geomify\Processor\Processor::add_name_to_inputs( $fields );
    $input  = new \geomify\Processor\Input();
?>
<div class="license-login">
    <div class="license-login-row">
        <div class="license-login-col">
            <img src="<?php geomify_brand_logo()?>" alt="<?php _e( 'Geomify brand logo', GTD )?>" class="inverted">
        </div>
    </div>
    <div class="license-login-row">
        <div class="license-login-col">
            <form action="#" class="license-login-form">
                <h2 class="uppercase">License login</h2>
                <?php
                    $input::create_field( $fields['email'] );
                    $input::create_field( $fields['personal_code'] );
                ?>
                <input type="checkbox" name="terms_accept" id="terms_accept"><label for="terms_accept">I accept <a
                        href="">Terms and Conditions</a></label>
                <div class="geomify-form-submit-btn"><i class="fas fa-sign-in-alt"></i> License login</div>
            </form>
        </div>
    </div>
</div>