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

    }

    /**
     * Create instance
     *
     * @return mixed
     */
    public static function stripe() {
        $self = new self();

        return $self->stripe;
    }

    /**
     * Return all subscriptions
     *
     * @return array|object
     */
    public static function subscription() {
        return self::stripe()->subscriptions;
    }

    /**
     * Retrieve all customers
     *
     * @return array|object
     */
    public static function customers() {
        return self::stripe()->customers;
    }

    /**
     * Retrieve all payment methods
     *
     * @return array|object
     */
    public static function payment_methods() {
        return self::stripe()->paymentMethods;
    }

    /**
     * Retrieve all invoices
     *
     * @return array|object
     */
    public static function invoices() {
        return self::stripe()->invoices;
    }

    /**
     * Return package id => name
     *
     * @return array
     */
    public static function packages() {
        $self = new self();

        return $self->packages;
    }

    /**
     * Printed package name => id
     *
     * @return array
     */
    public static function reverted_packages() {
        $pk     = self::packages();
        $result = [];

        foreach ( $pk as $key => $val ) {
            $result[$val] = $key;
        }

        return $result;
    }

    /**
     * Uppercase printed package name => id
     *
     * @return array
     */
    public static function reverted_packages_uc() {
        $pk = self::reverted_packages();

        foreach ( $pk as $key => $val ) {
            $pk[$key] = ucwords( $val );
        }

        return $pk;
    }

    /**
     * Upgrade a subscription
     *
     * @param  string         $subscription_id
     * @param  string         $price
     * @return object|array
     */
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

    /**
     * Create a subscription for customer
     *
     * @param  string         $customer_id
     * @param  string         $price
     * @return object|array
     */
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

    /**
     * Retrieve a subscription object
     *
     * @param  string         $id
     * @return object|array
     */
    public static function get_subscription( $id ) {
        return self::subscription()->retrieve( $id );
    }

    /**
     * Delete a subscription in stripe
     *
     * @param  string         $id
     * @return object|array
     */
    public static function cancel_subscription( $id ) {
        return self::subscription()->cancel( $id );
    }

    /**
     * Update customer infoin stripe
     *
     * @param  string         $id
     * @param  array          $atts
     * @return object|array
     */
    public static function update_customer( $id, $atts ) {
        return self::customers()->update(
            $id,
            $atts
        );
    }

    /**
     * Create a customer in stripe
     *
     * @param  array          $atts
     * @return object|array
     */
    public static function create_customer( $atts ) {
        return self::customers()->create( $atts );
    }

    /**
     * Retrieve a customer object from stripe
     *
     * @param  string         $id
     * @return object|array
     */
    public static function get_customer( $id ) {
        return self::customers()->retrieve( $id );
    }

    /**
     * Delete a customer form stripe
     *
     * @param  string         $id
     * @return object|array
     */
    public static function delete_customer( $id ) {
        return self::customers()->delete( $id );
    }

    /**
     * Create payment method for customer
     *
     * @param  array          $atts
     * @return object|array
     */
    public static function create_payment_method( $atts ) {
        return self::payment_methods()->create( $atts );
    }

    /**
     * Retrieve an added payment method object
     *
     * @param  string         $id
     * @return object|array
     */
    public static function get_payment_method( $id ) {
        return self::payment_methods()->retrieve( $id );
    }

    /**
     * Attach a payment method with customer account in stripe
     *
     * @param  string         $id
     * @param  string         $customer_id
     * @return object|array
     */
    public static function attach_payment_method( $id, $customer_id ) {
        return self::payment_methods()->attach( $id, ['customer' => $customer_id] );
    }

    /**
     * Detach a payment method from an customer in stripe
     *
     * @param  string         $id
     * @return object|array
     */
    public static function detach_payment_method( $id ) {
        return self::payment_methods()->detach( $id );
    }

    /**
     * Check if current user have payment method added or not
     *
     * @param  string    $type
     * @return boolean
     */
    public static function is_current_user_have_pm( $type = 'card' ) {
        $customer_id = User::stripe_customer_id();

        $methods = self::payment_methods()->all(
            [
                'customer' => $customer_id,
                'type'     => $type,
            ]
        );

        if ( empty( $methods->data ) ) {
            return false;
        }

        return true;
    }

    /**
     * Return a price id of package
     *
     * @param  string   $name
     * @return string
     */
    public static function package( $name = 'free' ) {
        return self::packages()[$name];
    }

    /**
     * Retrieve an invoice from stripe
     *
     * @param  string         $id
     * @return object|array
     */
    public static function get_invoice( $id ) {
        return self::invoices()->retrieve( $id );
    }

    public static function upgrade_subscription( $subscription_id, $package_name ) {
        // var_dump($subscription_id);exit;
        return self::subscription()->update(
            User::stripe_subscription_id(),
            [
                'items' => [
                    [
                        'id'    => $subscription_id,
                        'price' => self::package( $package_name ),
                    ],
                ],
            ]
        );
    }

    public static function pkg_val( $package_name ) {
        $pkg = [
            'free'        => 0,
            'basic'       => 1,
            'facilitator' => 2,
            'creator'     => 3,
            'enterprise'  => 4,
        ];

        return $pkg[$package_name];
    }

}