<div class="email-footer" style="
    background-color: white;
    padding: 50px 10%;
    text-align: center;">
    <p class="footer-p">
        You are receiving this email because you have signed up for a
        <?php echo is_user_logged_in() ? strtoupper( \geomify\Processor\User::current_subscription() ) : '' ?>
        Geomify Space. Your email address and personal information will be
        used by the the Geomify Team to communicate with you about Your
        Space and related services.<a href="<?php echo site_url( 'terms-of-use-privacy' ) ?>">User Terms</a> & <a
            href="<?php echo site_url( 'terms-of-use-privacy' ) ?>">Privacy Policy</a>
    </p>
    <div class="social-ico-holder" style="display: inline-block;
    margin: 20px 0;">
        <a href="https://twitter.com/Geomification" class="social-ico" target="_blank" style="padding: 8px 6px 8px;
margin: 0 10px;
font-size: 13px;
display: inline-block;
text-decoration: none;
color: steelblue;">Twitter</a>
        <a href="https://www.linkedin.com/company/2603948" class="social-ico" target="_blank" style="padding: 8px 6px 8px;
margin: 0 10px;
font-size: 13px;
display: inline-block;
text-decoration: none;
color: steelblue;">Linkedin</a>
        <a href="https://www.youtube.com/channel/UCcHoOtXCUcGdR7veY0AGFDA" class="social-ico" target="_blank" style="padding: 8px 6px 8px;
margin: 0 10px;
font-size: 13px;
display: inline-block;
text-decoration: none;
color: steelblue;">Youtube</a>
        <p class="footer-p">
            Copyright © Geomify Digital Twin by SANOY <?php echo date( 'Y', time() ) ?>
        </p>
    </div>