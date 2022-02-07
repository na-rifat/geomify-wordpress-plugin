<?php
    $user = new \geomify\Processor\User();
?>
<div style="text-align: center;">
    <h2>Dear <?php echo $user::first_name() ?> - Thank you for your license subscription!</h2>
    <br>
    <p>We are now setting up your license and you will soon receive
        an email with a temporary password and link to the license
        login page. If You should experience any difficulties logging in, do not
        hesitate to contact our support team: <a href="mailto:support@geomify.com">support@geomify.com</a></p>
    <br>
    <p>The GEOMIFY Team</p>
</div>