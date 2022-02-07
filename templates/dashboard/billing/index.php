<?php \geomify\Processor\User::is_logged() or exit; defined('ABSPATH') or exit; ?>
<?php
    $subscriptions        = \geomify\Processor\Geomify_stripe::packages();
    $payment_methods      = \geomify\Processor\User::stripe_payment_methods_caption();
    $current_subscription = \geomify\Processor\User::current_subscription();
?>

<div class="billing-section">
    <h2 class="billing-header">Billing</h2>
    <div class="billing-row">
        <h4 class="billing-subheader">
            Your subscription
        </h4>
        <div class="subscription-list-holder">
            <div>
                <?php echo ucwords( $current_subscription ) ?>
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
    <?php if ( \geomify\Processor\User::have_permit( 'basic' ) ) {
        ?>
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
    <?php
    }?>
    <div class="billing-row">
        <h4 class="billing-subheader">
            Balance
        </h4>
        <div class="invoices-holder">
        € <?php echo \geomify\Processor\User::stripe_balance()  ?>            
        </div>
    </div>
    <div class="billing-row">
        <h4 class="billing-subheader">
            Your invoices
        </h4>
        <div class="invoices-holder">
            <?php include 'invoices.php' ?>
        </div>
    </div>

</div>