<?php

namespace geomify\Processor;

defined( 'ABSPATH' ) or exit;

use Exception;
use \geomify\Processor\Geomify_stripe as Gstripe;
use \geomify\Processor\Processor as Processor;

/**
 * Non documented class
 */
class User {
    function __construct() {
        add_action( 'init', [$this, 'register_roles'] );
        add_action( 'delete_user', [$this, 'remove_from_stripe'] );
        add_action( 'geo_login', '\geomify\Processor\User::stripe_checkpost', 10, 2 );

        // exit(var_dump((\geomify\Processor\User::sub_price(9))));
        // exit(var_dump((self::stripe_balance())));
        // var_dump(self::get_meta('country'));
        // exit(var_dump(self::stripe_customer_id()));

        // exit(var_dump(Gstripe::package( 'basic' )));
        // exit(var_dump(Gstripe::tax_rates));
        // exit(var_dump( Processor::country_code( self::get_meta( 'country' ) )));

        // exit(var_dump(Gstripe::subscription()->update(
        //     self::stripe_subscription_id(),
        //     [
        //         'items'             => [
        //             [
        //                 'id'    => self::stripe_subscription_id(),
        //                 'price' => Gstripe::package( 'basic' ),
        //             ],
        //         ],
        //         'default_tax_rates' => Processor::country_code( self::get_meta( 'country' ) ) == 'DK' ? Gstripe::tax_rates : '',
        //         // 'automatic_tax'     => [
        //         //     'enabled' => true,
        //         // ],
        //     ]
        //     )));
        // exit(print_r($_SERVER));
    }

    public static function is_logged() {
        return (bool) is_user_logged_in();
    }

    public static function current_user() {
        return get_userdata( get_current_user_id() );
    }

    public static function id() {
        return get_current_user_id();
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
        return get_user_meta( self::id(), $key, $single );
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
        return self::is_activated( self::id() );
    }

    public static function set_meta( $key, $value ) {
        return update_user_meta( self::id(), $key, $value );
    }

    public static function get_meta( $key, $single = true ) {
        return get_user_meta( self::id(), $key, $single );
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

        if ( ! self::is_logged() ) {
            return;
        }

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
     * Get latest stripe invoice id
     *
     * @return Object
     */
    public static function latest_stripe_invoice_id() {
        $stripe_subscription_id = self::get_meta( 'stripe_subscription_id' );
        return Gstripe::get_subscription( $stripe_subscription_id )->latest_invoice;
    }

    /**
     * Return current user subscriptions object
     *
     * @return array|object
     */
    public static function stripe_subscriptions() {
        try {
            return Gstripe::get_subscription( self::stripe_subscription_id() )->items->data;
        } catch ( Exception $ex ) {
            self::set_meta( 'stripe_subscription_id', '' );
            self::set_meta( 'stripe_customer_id', '' );

            self::stripe_customer_id();

            return Gstripe::get_subscription( self::stripe_subscription_id() )->items->data;
        }
        exit;
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

        try {
            return Gstripe::stripe()->paymentMethods->all(
                [
                    'customer' => self::stripe_customer_id(),
                    'type'     => 'card',
                ]
            )->data;
        } catch ( Exception $ex ) {
            self::set_meta( 'stripe_customer_id', '' );
            self::set_meta( 'stripe_subscription_id', '' );
            self::stripe_customer_id();
            self::stripe_subscription_id();

            return Gstripe::stripe()->paymentMethods->all(
                [
                    'customer' => self::stripe_customer_id(),
                    'type'     => 'card',
                ]
            )->data;
        }
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

    /**
     * Check if current user have a specific subscription
     *
     * @param  String    $name
     * @return Boolean
     */
    public static function have_subscription( String $name ) {
        switch ( $name ) {
            case 'free':
                if (
                    self::have_sub( 'free' )
                    && ! self::have_sub( 'basic' )
                    && ! self::have_sub( 'facilitator' )
                    && ! self::have_sub( 'creator' )
                    && ! self::have_sub( 'enterprise' )
                ) {
                    return true;
                }

                break;
            case 'basic':
                if (
                    ! self::have_sub( 'free' )
                    && self::have_sub( 'basic' )
                    && ! self::have_sub( 'facilitator' )
                    && ! self::have_sub( 'creator' )
                    && ! self::have_sub( 'enterprise' )
                ) {
                    return true;
                }
                break;
            case 'facilitator':
                if (
                    ! self::have_sub( 'free' )
                    && ! self::have_sub( 'basic' )
                    && self::have_sub( 'facilitator' )
                    && ! self::have_sub( 'creator' )
                    && ! self::have_sub( 'enterprise' )
                ) {
                    return true;
                }
                break;
            case 'creator':
                if (
                    ! self::have_sub( 'free' )
                    && ! self::have_sub( 'basic' )
                    && ! self::have_sub( 'facilitator' )
                    && self::have_sub( 'creator' )
                    && ! self::have_sub( 'enterprise' )
                ) {
                    return true;
                }
                break;
            case 'enterprise':
                if (
                    ! self::have_sub( 'free' )
                    && ! self::have_sub( 'basic' )
                    && ! self::have_sub( 'facilitator' )
                    && ! self::have_sub( 'creator' )
                    && self::have_sub( 'enterprise' )
                ) {
                    return true;
                }
                break;
            default:
                return false;
                break;
        }
    }

    /**
     * Check if current user have any subscription
     *
     * @return Boolean
     */
    public static function subscribed() {
        if ( sizeof( self::stripe_subscriptions() ) == 0 ) {
            return false;
        }

        return true;
    }

    /**
     * Upgrade stripe subscription package
     *
     * @param  String         $package_name
     * @return Object|Array
     */
    public static function upgrade_package( String $package_name ) {
        return Gstripe::upgrade_subscription( self::stripe_subscriptions()[0]->id, $package_name );
    }

    /**
     * Check if user have permission for a subscription level
     *
     * @param  String    $package_name
     * @return boolean
     */
    public static function have_permit( String $package_name ) {
        $current_sub = self::current_subscription();

        return ( Gstripe::pkg_val( $package_name ) <= Gstripe::pkg_val( $current_sub ) );
    }

    /**
     * Create avatar by first letter of user name
     *
     * @return String
     */
    public static function avatar_name() {
        return substr( self::first_name(), 0, 1 ) . substr( self::last_name(), 0, 1 );
    }

    /**
     * Collect all invoices of current stripe user
     *
     * @return Object
     */
    public static function stripe_invoices() {
        return Gstripe::user_invoice_list( self::id() );
    }

    /**
     * Get stripe balance
     *
     * @return Int|Double
     */
    public static function stripe_balance() {
        return ( Gstripe::customers()->retrieve( self::stripe_customer_id() )->balance / 100 ) * -1;
    }

    /**
     * Calculate formatted subscription price
     *
     * @param  Int|Double   $price
     * @return Int|Double
     */
    public static function sub_price( $price ) {
        $bal = self::stripe_balance() * -1;
        $cal = $bal + $price;

        // var_dump($price);

        $have_vat = '';

        if ( self::get_meta( 'country' ) == 'Denmark' ) {
            $vat      = $cal * .25;
            $have_vat = " + {$vat}(25% VAT)";
        }

        return $cal < 0 ? 0 : $cal . $have_vat;
    }

    /**
     * Collect pending invoice items from Stripe
     *
     * @return Object|Array
     */
    public static function pending_invoice_items() {
        return Gstripe::stripe()->invoiceItems->all(
            [
                'customer' => self::stripe_customer_id(),
                'pending'  => true,
            ]
        )->data;
    }

    /**
     * Get subscription active status from stripe API
     *
     * @return boolean
     */
    public static function is_sub_active() {
        $sub = Gstripe::get_subscription( self::stripe_subscription_id() );
        return $sub->status === 'active' && ( $sub->pause_collection === '' || $sub->pause_collection === NULL );
    }

    /**
     * Remove stripe user account for specified user
     *
     * @param  int    $user_id
     * @return void
     */
    public function remove_from_stripe( $user_id ) {
        $cus_id = get_user_meta( $user_id, 'stripe_customer_id', true );

        if ( ! empty( $cus_id ) ) {
            Gstripe::customers()->delete( $cus_id );
        }
    }

    /**
     * Check if the user has initialized stripe, if not reinitialize stripe for the current user
     *
     * @param  Mixed  $userdata
     * @param  Object $user
     * @return void
     */
    public static function stripe_checkpost( $userdata, $user ) {
        $result = [
            'cus' => false,
            'sub' => false,
        ];

        $cus_id = get_user_meta( $user->ID, 'stripe_customer_id', true );
        $sub_id = get_user_meta( $user->ID, 'stripe_subscription_id', true );

        // Check post
        try {
            if ( $result['cus'] != true || empty( $cus_id ) ) {
                $customer = \geomify\Processor\Geomify_stripe::get_customer( $cus_id );

                if ( $customer->deleted == true ) {
                    $result['cus'] = true;
                }
            }
        } catch ( \Stripe\Exception\ApiErrorException $e ) {
            $result['cus'] = true;
        }

        try {
            if ( $result['sub'] != true || empty( $sub_id ) ) {
                $subscription = \geomify\Processor\Geomify_stripe::get_subscription( $sub_id );

                if ( $subscription->deleted == true ) {
                    $result['sub'] = false;
                }
            }
        } catch ( \Stripe\Exception\ApiErrorException $e ) {
            $result['sub'] = false;
        }
        // wp_logout();
        // wp_set_current_user(0);
        // wp_send_json_error(is_user_logged_in());
        // exit;

        // Recreation
        if ( $result['cus'] ) {
            // Initialize stripe
            $stripe_customer_id = Gstripe::create_customer(
                [
                    'email'       => $user->user_email,
                    'description' => 'Subscriber',
                    'name'        => "$user->first_name $user->last_name",
                ]
            )->id;

            $stripe_subscription_id = Gstripe::create_subscription( $stripe_customer_id, Gstripe::package( 'free' ) )->id;
            update_user_meta( $user->ID, 'stripe_customer_id', $stripe_customer_id );
            update_user_meta( $user->ID, 'stripe_subscription_id', $stripe_subscription_id );
        }

        if ( $result['sub'] && ! $result['cus'] ) {
            $stripe_subscription_id = Gstripe::create_subscription( $cus_id, Gstripe::package( 'free' ) )->id;
            update_user_meta( $user->ID, 'stripe_subscription_id', $stripe_subscription_id );
        }

        // Add customer to reverse tax rates
        if ( Processor::is_eu_country( User::get_meta( 'country' ) ) ) {
            Gstripe::update_customer( User::stripe_customer_id(), [
                'tax_exempt' => "reverse",
            ] );
        }
    }

    /**
     * Send password link to the user
     *
     * @param  String $user_email
     * @return void
     */
    public static function send_password_reset_link( $user_email ) {
        // If email
        if ( filter_var( $user_email, FILTER_VALIDATE_EMAIL ) ) {
            if ( ! email_exists( $user_email ) ) {
                wp_send_json_error(
                    [
                        'msg' => __( 'Account not found!' ),
                    ]
                );
                exit;
            }

            $user = get_user_by( 'email', $user_email );

            // If username
        } else {
            $user = get_user_by( 'login', $user_email );

            if ( ! $user ) {
                wp_send_json_error(
                    [
                        'msg' => __( 'Account not found!' ),
                    ]
                );
                exit;
            }
        }

        $_SESSION['geo_reset_user'] = $user->ID;

        // User found, send reset link
        geo_mail(
            $user->user_email,
            'Password reset link',
            'password_reset'
        );

        wp_send_json_success(
            [
                'msg' => __( 'Check your email for password reset link' ),
            ]
        );
        exit;
    }
}
