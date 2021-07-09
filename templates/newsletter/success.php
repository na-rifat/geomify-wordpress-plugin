<div class="newsletter-activated">    
    <div class="activation-text">
    <?php echo isset($_SESSION['ns_text']) ? $_SESSION['ns_text'] : 'No email found!'; unset(
        $_SESSION['ns_text']
    ); ?>
    </div>
    <br><br>
        <a href="<?php echo site_url() ?>" class="geomify-form-submit-btn">Go home</a>
</div>