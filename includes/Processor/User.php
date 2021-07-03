<?php

namespace geomify\Processor;

defined( 'ABSPATH' ) or exit;

use \geomify\Processor\Geomify_stripe as Gstripe;

/**
 * Non documented class
 */
class User {
    function __construct() {
        add_action( 'init', [$this, 'register_roles'] );
    }

    public static function is_logged() {
        return is_user_logged_in();
    }

    public static function current_user() {
        // static $current_user = false;

        // if ( $current_user !== false ) {
        // }
        $current_user = get_userdata( get_current_user_id() );

        return $current_user;
    }

    public static function id() {
        return self::current_user()->ID;
    }

    public static function email() {
        return self::current_user()->user_email;
    }

    public static function first_name() {
        return self::current_user()->first_name;
    }

    public static function last_name() {
        return self::current_user()->last_name;
    }

    public static function name() {
        return self::first_name() . ' ' . self::last_name();
    }

    public static function password() {
        return self::current_user()->password;
    }

    public static function current_user_id() {
        return self::current_user()->ID;
    }

    public static function current_user_first_name() {
        return self::current_user()->first_name;
    }

    public static function current_user_last_name() {
        return self::current_user()->last_name;
    }

    public static function current_user_email() {
        return self::current_user()->user_email;
    }

    public static function current_user_login() {
        return self::current_user()->user_login;
    }

    public static function current_user_roles() {
        return self::current_user()->roles;
    }

    public static function current_user_meta( $key, $single = true ) {
        return get_user_meta( self::current_user_id(), $key, $single );
    }

    public static function current_user_stripe_id() {
        return self::current_user_meta( 'stripe_id' );
    }

    public static function is_current_user_admin() {
        if ( in_array( 'Administrator', self::current_user_roles() ) ) {
            return true;
        }

        return false;
    }

    public static function get( $user_id ) {
        return get_userdata( $user_id );
    }

    public function register_roles() {
        // add_role( 'user', __( 'User' ), get_role( 'subscriber' )->capabilities );
    }

    public function activate() {

    }

    public static function is_activated( $user_id ) {
        return get_user_meta( $user_id, 'activated', true );
    }

    public static function is_current_user_activated() {
        return self::is_activated( self::current_user_id() );
    }

    public static function set_meta( $key, $value ) {
        return update_user_meta( self::current_user_id(), $key, $value );
    }

    public static function get_meta( $key, $single = true ) {
        return get_user_meta( self::current_user_id(), $key, $single );
    }

    public static function stripe_customer_id() {
        $stripe_user_id = self::get_meta( 'stripe_customer_id' );

        if ( empty( $stripe_customer_id ) ) {
            $stripe_customer_id = Gstripe::create_customer(
                [
                    'email'       => self::email(),
                    'description' => 'Subscriber',
                    'name'        => self::name(),
                ]
            )->id;
        }

        return $stripe_user_id;
    }

    public static function stripe_subscription_id() {
        return self::get_meta( 'stripe_subscription_id' );
    }

    public static function initialize_stripe() {
        $stripe_customer_id = Gstripe::create_customer(
            [
                'email'       => self::email(),
                'description' => 'Subscriber',
                'name'        => self::name(),
            ]
        )->id;

        $stripe_subscription_id = Gstripe::create_subscription( $stripe_customer_id, Gstripe::package( 'free' ) )->id;

        self::set_meta( 'stripe_customer_id', $stripe_customer_id );
        self::set_meta( 'stripe_subscription_id', $stripe_subscription_id );
        self::set_meta( 'stripe_subscriptions', ['free'] );
    }

    public static function latest_stripe_invoice() {
        $stripe_subscription_id = self::get_meta( 'stripe_subscription_id' );
        $latest_invoice_id      = Gstripe::get_subscription( $stripe_subscription_id )->latest_invoice;

        return Gstripe::invoices()->retrieve( $latest_invoice_id );
    }

}