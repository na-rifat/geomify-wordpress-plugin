<?php
    $package_name = geomify_var( 'package_name' );
    $package      = \geomify\Schema\Schema::get( 'packages' )[$package_name];
    $current_pkg = \geomify\Processor\User::current_subscription();
    $is_down = \geomify\Processor\Geomify_stripe::pkg_val($package_name) < \geomify\Processor\Geomify_stripe::pkg_val($current_pkg);
?>

<div class="payment-holder">
    <div class="payment-row payment-header">
        <div class="payment-col">
            <img class="inverted payment-logo" src="<?php geomify_brand_logo()?>" alt="<?php _e( 'Brand logo', GTD )?>">
        </div>
        <div class="payment-col">
            <h4 class="blue-text uppercase"><?php echo $is_down ? 'Downgrade': 'Upgrade'  ?> to</h4>
            <h2><?php echo $package['label'] ?></h2>
            <br>
            <h2><?php printf( '%s €/mo', geomify_monthly_price( $package['price'] ) )?></h2>
            <h4 class="blue-text">Billed annually</h4>
        </div>
    </div>
    <br><br><br>
    <div class="pay-section">
        <div class="payment-row">
            <form action="" class="payment-form upgrade-form">
                <input type="hidden" name="package_name" id="package_name" value="<?php echo $package_name ?>">
                <h2 class="upgrade-confirmation-text">You're about to upgrade your package to                                                                                                                                                                                           <?php echo $package['label'] . '. ' ?>
                    Do you want to proceed?</h2>
                <br>
                <div class="payment-input-group upgrade-buttons">
                    <input type="submit" value="<?php printf( 'Proceed and pay € %s', $package['price'] )?>"
                        class="geomify-form-submit-btn">
                        <div class="geomify-form-submit-btn cancel-upgrade">Cancel</div>
                </div>
                <div class="payment-input-group">
                    <?php if($is_down){
                        ?>
                        <div style="color: red; font-size: 12px;">*Previously paid invoice(s) won't refund on downgrade*</div>
                        <?php
                    } ?>
                </div>
            </form>
        </div>
    </div>
    <script>
    handlePayment();
    </script>
</div>