<?php
    $fields = \geomify\Schema\Schema::get( 'license_login' );
    $fields = \geomify\Processor\Processor::add_name_to_inputs( $fields );
    $input  = new \geomify\Processor\Input();
?>
<div class="license-login">
    <div class="license-login-row">
        <div class="license-login-col">
            <img  style="text-align: center; height: 130px; width: auto; margin: 10px auto 30px auto;"  src="<?php echo site_url( 'wp-content/uploads/2021/07/Stack-white.png' ) ?>" alt="<?php _e( 'Geomify brand logo', GTD )?>" class="inverted">
        </div>
    </div>
    <div class="license-login-row">
        <div class="license-login-col">
            <form action="#" class="license-login-form">
                <a target="_blank" href="https://geomify.nextspace.host" class="geomify-form-submit-btn"><i
                        class="fas fa-sign-in-alt"></i> License login</a>
                <h6 style="color: #4682b4; margin: 15px 0 0 0;    text-align: center;
    color: #51A7F9;
    font-family: 'Open Sans', Sans-serif;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;" class="blue-text">LOGIN TO</h6>
                <div style="color: black;">FACILITATOR</div>
                <div style="color: black;">CREATOR</div>
                <div style="color: black;">ENTERPRISE</div>
            </form>
        </div>
    </div>
</div>