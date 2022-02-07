<?php
    $user_id    = $_SESSION['geo_reset_user'];
    $reset_code = $user_id . time() * 2;
    $reset_code = str_shuffle( $reset_code );
    update_user_meta( $user_id, 'geo_reset_code', $reset_code );
    update_user_meta( $user_id, 'geo_reset_start', time() );

    $link = site_url( sprintf( 'reset-password?user=%s&token=%s', $user_id, $reset_code ) );
?>
<div class="email-body" style="padding: 50px 15%;
    background-color: white;
    border-bottom: 1px solid #ccc;
    text-align: center;">
    <h1>RESET PASSWORD REQUEST</h1>
    <p>You just requested to reset your password. In case this was NOT you, please do not mind this email, but instead
        evaluate if you actually should reset your password. In such case, we recommend that you enter your own re-set
        psasword request from the login page on our website.</p>
    <div style="font-size: 11px; color: gray;">Click the button below to reset your password</div>
    <div class="button-holder" style=" margin:  20px 0; display: inline-block;">
        <a href="<?php echo $link ?>" class="geo-button" target="_blank" style=" border-radius: 3px;
    border: 2px solid #51a7f9;
    background-color: #51a7f9;
    color: #ffffff;
    padding: 12px 60px;
    text-decoration: none;
    font-weight: bold;
    transition: .3s all linear;
    text-align: center;">
            <?php _e( 'RESET PASSWORD', GTD )?>
        </a>
    </div>
</div>