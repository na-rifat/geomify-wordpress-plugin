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
        if ( in_array( 'administrator', self::current_user_roles() ) ) {
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

    /**
     * Get stripe customer id
     *
     * Create customer on empty id
     *
     * @return string
     */
    public static function stripe_customer_id() {
        $stripe_customer_id = self::get_meta( 'stripe_customer_id' );

        if ( empty( $stripe_customer_id ) ) {
            $stripe_customer_id = Gstripe::create_customer(
                [
                    'email'       => self::email(),
                    'description' => 'Subscriber',
                    'name'        => self::name(),
                ]
            )->id;

            self::set_meta( 'stripe_customer_id', $stripe_customer_id );
        }

        return $stripe_customer_id;
    }

    /**
     * Get stripe subscription id
     *
     * Create free subscription on empty id
     *
     * @return string
     */
    public static function stripe_subscription_id() {
        $stripe_subscription_id = self::get_meta( 'stripe_subscription_id' );

        if ( empty( $stripe_subscription_id ) ) {
            $stripe_subscription_id = Gstripe::create_subscription(
                self::stripe_customer_id(),
                Gstripe::package( 'free' )
            )->id;

            self::set_meta( 'stripe_subscription_id', $stripe_subscription_id );
        }

        return $stripe_subscription_id;
    }

    /**
     * Intialize/Create stripe account for current user
     *
     * @return void
     */
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

    /**
     * Return latest invoice of current user
     *
     * @return array|object
     */
    public static function latest_stripe_invoice() {
        $stripe_subscription_id = self::get_meta( 'stripe_subscription_id' );
        $latest_invoice_id      = Gstripe::get_subscription( $stripe_subscription_id )->latest_invoice;

        return Gstripe::invoices()->retrieve( $latest_invoice_id );
    }

    /**
     * Return current user subscriptions object
     *
     * @return array|object
     */
    public static function stripe_subscriptions() {
        return Gstripe::get_subscription( self::stripe_subscription_id() )->items->data;
    }

    /**
     * Return caption of current user subscriptions
     *
     * @return array
     */
    public static function stripe_subscriptions_caption() {
        $subs     = self::stripe_subscriptions();
        $packages = Gstripe::reverted_packages_uc();
        $result   = [];

        foreach ( $subs as $sub ) {
            $result[$sub->price->id] = $packages[$sub->price->id];
        }

        return $result;
    }

    /**
     * Return stripe payment methods of current user
     *
     * @return mixed
     */
    public static function stripe_payment_methods() {
        return Gstripe::stripe()->paymentMethods->all(
            [
                'customer' => self::stripe_customer_id(),
                'type'     => 'card',
            ]
        )->data;
    }

    public static function stripe_payment_methods_caption() {
        $methods = self::stripe_payment_methods();
        $result  = [];

        foreach ( $methods as $method ) {
            $result[] = [
                'id'         => $method->id,
                'brand'      => ucwords( $method->card->brand ),
                'last4'      => $method->card->last4,
                'exp_month'  => $method->card->exp_month,
                'exp_year'   => $method->card->exp_year,
                'type'       => ucwords( $method->type ),
                'created_at' => $method->created,
            ];
        }

        return $result;
    }

    public static function all_subscriptions() {
        static $items = false;

        if ( $items == false ) {
            $items  = self::stripe_subscriptions_caption();
            $result = [];
            foreach ( $items as $key => $value ) {
                $result[] = strtolower( $value );
                unset( $items[$key] );
                $items[] = strtolower( $value );
            }
        } else {
            $result = $items;
        }

        return $result;
    }

    public static function have_sub( $name ) {
        return in_array( $name, self::all_subscriptions() == null ? [] : self::all_subscriptions() );
    }

    public static function current_subscription() {
        return self::all_subscriptions()[0];
    }

    public static function have_subscription( $name ) {
        switch ( $name ) {
            case 'free':
                if ( self::have_sub( 'free' )
                    && ! self::have_sub( 'basic' )
                    && ! self::have_sub( 'facilitator' )
                    && ! self::have_sub( 'creator' )
                    && ! self::have_sub( 'enterprise' )
                ) {
                    return true;
                }

                break;
            case 'basic':
                if ( ! self::have_sub( 'free' )
                    && self::have_sub( 'basic' )
                    && ! self::have_sub( 'facilitator' )
                    && ! self::have_sub( 'creator' )
                    && ! self::have_sub( 'enterprise' )
                ) {
                    return true;
                }
                break;
            case 'facilitator':
                if ( ! self::have_sub( 'free' )
                    && ! self::have_sub( 'basic' )
                    && self::have_sub( 'facilitator' )
                    && ! self::have_sub( 'creator' )
                    && ! self::have_sub( 'enterprise' )
                ) {
                    return true;
                }
                break;
            case 'creator':
                if ( ! self::have_sub( 'free' )
                    && ! self::have_sub( 'basic' )
                    && ! self::have_sub( 'facilitator' )
                    && self::have_sub( 'creator' )
                    && ! self::have_sub( 'enterprise' )
                ) {
                    return true;
                }
                break;
            case 'enterprise':
                if ( ! self::have_sub( 'free' )
                    && ! self::have_sub( 'basic' )
                    && ! self::have_sub( 'facilitator' )
                    && ! self::have_sub( 'creator' )
                    && self::have_sub( 'enterprise' )
                ) {
                    return true;
                }break;
            default:
                return false;
                break;
        }
    }

    public static function subscribed() {
        if ( sizeof( self::stripe_subscriptions() ) == 0 ) {
            return false;
        }

        return true;
    }

    public static function upgrade_package( $package_name ) {
        return Gstripe::upgrade_subscription( self::stripe_subscriptions()[0]->id, $package_name );
    }

    public static function have_permit( $package_name ) {
        $current_sub = self::current_subscription();

        return ( Gstripe::pkg_val( $package_name ) <= Gstripe::pkg_val( $current_sub ) );
    }

    public static function avatar_name() {
        return substr( self::first_name(), 0, 1 ) . substr( self::last_name(), 0, 1 );
    }

    public static function stripe_invoices() {
        return Gstripe::user_invoice_list( self::id() );
    }

    

}