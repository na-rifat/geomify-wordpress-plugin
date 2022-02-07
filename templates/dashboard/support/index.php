<?php \geomify\Processor\User::is_logged() or exit; defined('ABSPATH') or exit; ?>

<div class="gtab-holder">
    <div class="gtab-header">
        <div class="header-item">
            <h2>Write to our support team</h2>
            <p>We respond to support request within 48 hours, Monday to Friday</p>
            <br>
        </div>
    </div>
    <br>
    <div class="gtab-body">
        <?php echo do_shortcode( '[contact-form-7 id="2491" title="Support form"]' ) ?>
    </div>
</div>