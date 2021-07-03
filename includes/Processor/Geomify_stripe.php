<?php

namespace geomify\Processor;

defined( 'ABSPATH' ) or exit;

use Stripe\StripeClient;
use Stripe\Subscription;
use \Stripe\Stripe as Stripe;

class Geomify_stripe {
    function __construct() {
        $this->api['secret_key']      = 'sk_test_51IsOwqJzUoZfpUOBKQQ1KZFbkONpQW1i6q0xeYRsEIkoX1uKgtYarw7PfAu3qTE2QhRjr5vWPofHjYrojXHFGCVJ00VL17Uuvh';
        $this->api['publishable_key'] = 'pk_test_51IsOwqJzUoZfpUOBfjac0gn4zeKQLPbDrbSRjYx6VoyRc29vLjmeBUMmpsU8fRjuObPPD8R4jDGV7ZrrFkF8wqVs00JdMzCP1x';
        $this->api['stripe_account']  = 'acct_1IsOwqJzUoZfpUOB';
        $this->packages               = [
            'free'        => 'price_1IxbXJJzUoZfpUOBhBrSfqxl',
            'basic'       => 'price_1IxbXbJzUoZfpUOBnCK9Yb07',
            'facilitator' => 'price_1IxbXxJzUoZfpUOB22keNbKC',
            'creator'     => 'price_1Ixp22JzUoZfpUOBWT8YWfSc',
            'enterprise'  => 'price_1Ixp5kJzUoZfpUOBgpXq5GWp',
        ];

        Stripe::setApiKey( $this->api['secret_key'] );
        Stripe::setAppInfo(
            __( 'Geomify', GTD ),
            '1.0.0',
            'https://rafalotech.com/wp/plugins/goemify'
        );

        $this->stripe       = new StripeClient( $this->api['secret_key'] );
        $this->subscription = new Subscription();

        $this->init_stripe();
    }

    public static function stripe() {
        $self = new self();

        return $self->stripe;
    }

    public static function subscription() {
        return self::stripe()->subscriptions;
    }

    public static function customers() {
        return self::stripe()->customers;
    }

    public static function payment_methods() {
        return self::stripe()->paymentMethods;
    }

    public static function invoices() {
        return self::stripe()->invoices;
    }

    public static function packages() {
        $self = new self();

        return $self->packages;
    }

    public function init_stripe() {
        // $this->stripe::setApiKey( $this->api['secret_key'] );
        // $this->stripe::setAppInfo( 'Geomify Stripe API', '1.0.0', 'https://rafalotech.com/wp/plugins/geomify' );
    }

    // public static function create_customer( $atts ) {
    //     $self = new self();

    //     return $self->stripe->customers->create(
    //         [
    //             'description'    => 'Subscriber customer',
    //             'email'          => $atts['email'],
    //             'payment_method' => 'pm_card_visa',
    //         ]
    //     );
    // }

    // public static function create_subscription( $atts ) {
    //     $self = new self();

    //     return $self->stripe->subscriptions->create(
    //         [
    //             'customer' => $atts['stripe_id'],
    //             'items'    => [
    //                 ['price' => $atts['subscription']],
    //             ],
    //         ]
    //     );
    // }

    public static function update_subscription( $subscription_id, $price ) {
        return self::subscription()->update(
            $subscription_id,
            [
                'items' => [
                    ['price' => $price],
                ],
            ]
        );
    }

    public static function create_subscription( $customer_id, $price ) {
        return self::subscription()->create(
            [
                'customer' => $customer_id,
                'items'    => [
                    ['price' => $price],
                ],
            ]
        );
    }

    public static function get_subscription( $id ) {
        return self::subscription()->retrieve( $id );
    }

    public static function cancel_subscription( $id ) {
        return self::subscription()->cancel( $id );
    }

    public static function update_customer( $id, $atts ) {
        return self::customers()->update(
            $id,
            $atts
        );
    }

    public static function create_customer( $atts ) {
        return self::customers()->create( $atts );
    }

    public static function get_customer( $id ) {
        return self::customers()->retrieve( $id );
    }

    public static function delete_customer( $id ) {
        return self::customers()->delete( $id );
    }

    public static function create_payment_method( $atts ) {
        return self::payment_methods()->create( $atts );
    }

    public static function get_payment_method( $id ) {
        return self::payment_methods()->retrieve( $id );
    }

    public static function attach_payment_method( $id, $customer_id ) {
        return self::payment_methods()->attach( $id, ['customer' => $customer_id] );
    }

    public static function detach_payment_method( $id ) {
        return self::payment_methods()->detach( $id );
    }

    public static function is_current_user_have_pm( $type = 'card' ) {
        $customer_id = User::stripe_customer_id();

        $methods = self::payment_methods()->all(
            [
                'customer' => $customer_id,
                'type'     => $type,
            ]
        );
        // wp_send_json_error($methods);exit;

        if ( empty( $methods->data ) ) {
            return false;
        }

        return true;
    }

    public static function package( $name = 'free' ) {
        return self::packages()[$name];
    }

    public static function get_invoice( $id ) {
        return self::invoices()->retrieve( $id );
    }

}