<?php
// $gs = new \geomify\Processor\Geomify_stripe();
// $gs->stripe->paymentMethods->attach(
//     'pm_13',
//     [
//         'customer'=>'cus_JZqwkofDHU9mCE'
//     ]
// );
// \geomify\Processor\Geomify_stripe::update_subscription(
//     [
//         'subscription_id'=>'sub_JZqwjjqlhd7lyb',
//         'subscription'=>\geomify\Processor\Geomify_stripe::packages()['facilitator']
//     ]
//     );

// var_dump(\geomify\Processor\Geomify_stripe::package( 'free' ));
// echo \geomify\Processor\Geomify_stripe::create_subscription(
//     'cus_JbXk8WqjiC3GPz',
//     [
//         ['price'=> \geomify\Processor\Geomify_stripe::package( 'free' )],
//     ]
// );
use \geomify\Processor\Geomify_stripe as Gstripe;
// echo $latest_invoice_id = Gstripe::stripe()->customers->retrieve( 'cus_Je3H6MMtO6zZTv' );
// echo  Gstripe::get_customer( 'cus_Je3H6MMtO6zZTv' );
// $latest_invoice_id = Gstripe::get_customer( 'cus_Je3H6MMtO6zZTv' )->latest_invoice;
// echo $latest_invoice = Gstripe::get_invoice($latest_invoice_id);
// $latest_invoice_id = Gstripe::get_subscription( 'sub_Je3Hsu0i5YCv4n' )->latest_invoice;
//             $latest_invoice    = Gstripe::get_invoice( $latest_invoice_id );
//             printf('<script>console.log(%s)</script>',json_encode($latest_invoice));

echo Gstripe::update_subscription('sub_Je3Hsu0i5YCv4n', "price_1IxbXxJzUoZfpUOB22keNbKC");