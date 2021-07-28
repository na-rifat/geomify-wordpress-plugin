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
                <a target="_blank" href="https://ui.geomify.host" class="geomify-form-submit-btn"><i
                        class="fas fa-sign-in-alt"></i> License login</a>
                <h6 style="color: #4682b4; margin: 15px 0 0 0;" class="blue-text">LOGIN TO</h6>
                <div style="color: black;">FACILITATOR</div>
                <div style="color: black;">CREATOR</div>
                <div style="color: black;">ENTERPRISE</div>
            </form>
        </div>
    </div>
</div>