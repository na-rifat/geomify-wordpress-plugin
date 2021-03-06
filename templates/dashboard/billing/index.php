<?php
    $subscriptions   = \geomify\Processor\User::stripe_subscriptions_caption();
    $payment_methods = \geomify\Processor\User::stripe_payment_methods_caption();
?>

<div class="billing-section">
    <h2 class="billing-header">Billing</h2>
    <div class="billing-row">
        <h4 class="billing-subheader">
            Your subscriptions
        </h4>
        <div class="subscription-list-holder">
            <?php
                foreach ( $subscriptions as $sub => $caption ) {
                    printf( '<div class="billing-sub-item">%s</div>', $caption );
                }
            ?>
        </div>
    </div>
    <div class="billing-row">
        <h4 class="billing-subheader">
            Your payment methods
        </h4>
        <div class="payment-methods-holder">
            <?php
                foreach ( $payment_methods as $method ) {
                ?>
                        <div class="billing-method-item" data-id="<?php echo $method['id'] ?>">
                            <div class="bmi-col">
                                <div class="bmi-row">
                                    Type: <?php echo $method['type'] ?>
                                </div>
                                <div class="bmi-row">
                                    Brand: <?php echo $method['brand'] ?>
                                </div>
                            </div>
                            <div class="bmi-col">
                                <div class="bmi-row">
                                    **** **** **** <?php echo $method['last4'] ?>
                                </div>
                                <div class="bmi-row">
                                    Exp: <?php echo $method['exp_month'] ?>/<?php echo $method['exp_year'] ?>
                                </div>
                            </div>
                            <div class="bmi-col">
                                <i class="dlt-pm fas fa-trash-alt"></i>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
        </div>
    </div>
</div>