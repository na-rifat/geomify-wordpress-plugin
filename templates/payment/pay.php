<?php
    $package_name = geomify_var( 'package_name' );
    $current_pkg  = \geomify\Processor\User::current_subscription();
    $is_down      = \geomify\Processor\Geomify_stripe::pkg_val( $package_name ) < \geomify\Processor\Geomify_stripe::pkg_val( $current_pkg );
    $package      = \geomify\Schema\Schema::get( 'packages' )[$package_name];
?>

<div class="payment-holder">
    <div class="payment-row payment-header">
        <div class="payment-col">
            <img class="inverted payment-logo" src="<?php geomify_brand_logo()?>" alt="<?php _e( 'Brand logo', GTD )?>">
        </div>
        <div class="payment-col">
            <h4 class="blue-text uppercase"><?php echo $is_down ? 'Downgrade' : 'Upgrade' ?> to</h4>
            <h2 style="font-size: 2rem;"><?php echo $package['label'] ?></h2>
            <br>
            <h2><?php printf( '%s €/mo', geomify_monthly_price( $package['price'] ) )?></h2>
            <h4 class="blue-text">Billed annually</h4>
        </div>
    </div>
    <div class="pay-section">
        <div class="payment-row">
            <div class="payment-col">
                <div><strong>Select a payment method</strong></div>
                <div class="payment-method-list">
                    <div class="method-item active-item" data-name="card">
                        <div class="method-icon"><i class="far fa-credit-card"></i></div>
                        <div class="method-title">Card</div>
                    </div>
                    <div class="method-item" data-name="bank">
                        <div class="method-icon"><i class="fas fa-university"></i></div>
                        <div class="method-title">Bank transfer</div>
                    </div>
                </div>
                <br>
            </div>
        </div>
        <div class="payment-row">
            <div class="method-option active-item">
                <div><strong>Card information</strong></div>
                <form action="" class="payment-form payment-card">

                    <input type="hidden" name="type" value="card">
                    <input type="hidden" name="package_name" id="package_name" value="<?php echo $package_name ?>">
                    <div class="payment-box">
                        <div class="payment-input-group">
                            <input type="text" placeholder="1234 1234 1234 1234" name="card_number" id="card_number"
                                required min="16" max="16">
                        </div>
                        <div class="payment-input-group have-expiry">
                            <input type="text" placeholder="MM" name="expire_month" id="expire_month" required min="2"
                                max="2">
                            <input type="text" placeholder="YYYY" name="expire_year" id="expire_year" required min="2"
                                max="2">
                            <input type="text" placeholder="CVC" name="cvc" id="cvc" required min="3" max="3">
                        </div>
                    </div>
                    <br>
                    <div class="payment-input-group">
                        <input type="submit"
                            value="<?php  printf( 'Proceed and pay € %s', \geomify\Processor\User::sub_price( $package['price'] ) )?>"
                            class="geomify-form-submit-btn">
                    </div>
                    <div class="payment-input-group">
                        <div style="color: green; text-align:center;">*Price may vary with account balance adjustments*</div>
                    </div>
                </form>
            </div>
            <div class="method-option">

            </div>
        </div>
    </div>
    <script>
    handlePayment();
    </script>
</div>