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
// exit( gettype( \geomify\Processor\User::stripe_subscriptions()->items ) );
// var_dump( \geomify\Processor\User::paymentMethods() );
// echo $latest_invoice_id = Gstripe::stripe()->customers->retrieve( 'cus_Je3H6MMtO6zZTv' );
// echo  Gstripe::get_customer( 'cus_Je3H6MMtO6zZTv' );
// $latest_invoice_id = Gstripe::get_customer( 'cus_Je3H6MMtO6zZTv' )->latest_invoice;
// echo $latest_invoice = Gstripe::get_invoice($latest_invoice_id);
// $latest_invoice_id = Gstripe::get_subscription( 'sub_Je3Hsu0i5YCv4n' )->latest_invoice;
//             $latest_invoice    = Gstripe::get_invoice( $latest_invoice_id );
//             printf('<script>console.log(%s)</script>',json_encode($latest_invoice));

// echo Gstripe::update_subscription('sub_Je3Hsu0i5YCv4n', "price_1IxbXxJzUoZfpUOB22keNbKC");

// \geomify\Processor\Templates::_get('email/header');
// \geomify\Processor\Templates::_get('email/account-activate');
// \geomify\Processor\Templates::_get('email/footer');


// 
// var_dump(\geomify\Processor\User::have_subscription('basic'));
var_dump(\geomify\Processor\User::all_subscriptions());
var_dump(\geomify\Processor\User::all_subscriptions());