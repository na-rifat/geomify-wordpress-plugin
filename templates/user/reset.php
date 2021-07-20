<div class="user-login-holder">
    <form class="ur-row">
        <?php if(isset($_GET['user']) && isset($_GET['token']) && get_user_meta($_GET['user'], 'geo_reset_code', true) == $_GET['token']) {
           ?>
        <div class="ul-col">
            <img src="<?php echo wp_get_attachment_url( '3297' ) ?>" class="brand-logo" />
        </div>
        <div class="ul-col">
            <h2>Password reset</h2>
        </div>
        <div class="ul-col">
            <div class="ul-input-row">
                <label for="password">Type your new password:</label>
                <input type="password" name="password" id="password" placeholder="********">
            </div>
        </div>
        <div class="ul-col">
            <div class="ul-input-row">
                <label for="confirm_password">Confirm password:</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="********">
            </div>
        </div>
        <div class="ul-col btn-col">
            <div class="reset-btn">
                Reset
            </div>
            <input type="hidden" name="user" value="<?php echo $_GET['user'] ?>">
            <input type="hidden" name="token" value="<?php echo $_GET['token'] ?>">
            <a href="<?php echo site_url( 'sign-in' ) ?>" class="start-free-btn">Sign in</a>
        </div>
        <?php
       }else{
           ?>
        <div class="ul-col">
            <img src="<?php echo wp_get_attachment_url( '3297' ) ?>" class="brand-logo" />
        </div>
        <div class="ul-col">
            <h2>Password reset</h2>
        </div>
        <div class="ul-col">
            <div class="ul-input-row">
                <label for="user_email">User name:</label>
                <input type="text" name="user_email" id="user_email" placeholder="Enter user name or email">
            </div>
        </div>
        <div class="ul-col btn-col">
            <div class="login-btn">
                Reset
            </div>
            <a href="<?php echo site_url( 'start-free' ) ?>" class="start-free-btn">Start free</a>
        </div>
        <div class="ul-col f-pass">
            Remember your password?
            <a href="<?php echo site_url( 'sign-in' ) ?>">Login to your account</a>
        </div>
        <?php
       }?>
    </form>
</div>