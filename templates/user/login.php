<div class="user-login-holder">
    <form class="ul-row">
        <div class="ul-col">
            <img src="<?php echo wp_get_attachment_url( '3297' ) ?>" class="brand-logo" />
        </div>
        <div class="ul-col">
            <h2>User space login</h2>
        </div>
        <div class="ul-col">
            <div class="mobile-disclaimer">
                DISCLAIMER<br> <br>
                The GEOMIFY User Space is not designed
                for SmartPhones or Tablets. The best user
                experience is to login from your computer.
                NOTE that Project Views only can be
                accessed from your computer <br><br>
                <div class="geomify-form-submit-btn">Continue login</div>
            </div>
        </div>
        <div class="ul-col ul-hd">
            <div class="ul-input-row">
                <label for="user_email">User name:</label>
                <input type="text" name="user_email" id="user_email" placeholder="Enter user name or email">
            </div>
            <div class="ul-input-row">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="********">
            </div>
        </div>
        <div class="ul-col  agree-col ul-hd">
            <input type="checkbox" name="agree" id="agree" value="agree"><label for="agree">I accept <a
                    href="<?php echo site_url( 'terms-of-use-privacy' ) ?>">Terms & Conditions</a></label>
        </div>
        <div class="ul-col btn-col ul-hd">
            <div class="login-btn">
                Login
            </div>
            <a href="<?php echo site_url( 'start-free' ) ?>" class="start-free-btn">Start free</a>
        </div>
        <div class="ul-col f-pass">
            Forgot your password?
            <a href="<?php echo site_url( 'reset-password' ) ?>">Reset password</a>
        </div>
    </form>
</div>