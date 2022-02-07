<?php

namespace geomify\Processor;

defined( 'ABSPATH' ) or exit;

use \geomify\Processor\Power as Power;
use \geomify\Processor\User as User;

class Redirect {
    function __construct() {
        add_action( 'template_redirect', [$this, 'redirect'] );
        add_action( 'wp_logout', [$this, 'admin_logout'], 9999 );
    }

    // Redirect users to different pages based on specific conditions
    public function redirect() {

        $current_page = Power::current_page();
        $parent_page  = Power::current_parent();
        $is_logged_in = is_user_logged_in();

        if ( $is_logged_in ) {
            $current_user       = User::current_user();
            $current_user_id    = $current_user->ID;
            $is_activated       = get_user_meta( $current_user_id, 'activated', true );
            $activation         = isset( $_GET['user'] ) ? get_user_meta( $_GET['user'], 'activated', true ) : false;
            $current_roles      = User::current_user_roles();
            $current_user_roles = $current_roles == null ? [] : $current_roles;
            $is_sub_active      = User::is_sub_active();
            $is_user_admin      = User::is_current_user_admin();
        }

        // Dashboard
        if ( $current_page === 'dashboard' ) {
            Power::go( 'dashboard/project-views' );
        }

        // Prevent user to go account acivation page if logged in
        if ( $is_logged_in && $current_page == 'activation' && $activation == true ) {
            Power::go( 'dashboard/project-views' );
        }

        // Redirect user to activation page
        if ( isset( $_GET['action'] ) && $_GET['action'] == 'activate-user'
            && $current_page != 'activation' && isset( $_GET['user'] )
            && isset( $_GET['key'] ) ) {

            Power::go( sprintf( 'activation?action=activate-user&user=%s&key=%s', $_GET['user'], $_GET['key'] ) );
        }

        // Prevent user to go sign or reset password page if logged in
        if ( $is_logged_in && ( $current_page == 'sign-in' || $current_page == 'reset-password' ) ) {
            Power::go( 'dashboard' );
        }

        // Redirect user to subscription not activated page if subscription from stripe isn't active
        if ( $is_logged_in && $parent_page == 'dashboard' && ! $is_user_admin
            && ! $is_sub_active && $current_page !== 'subscription-not-activated'
            && $current_page !== 'logout' && $current_page !== 'support' ) {

            Power::go( 'subscription-not-activated' );
        }

        // Prevent user to subscription not activated page if user isn't logged in
        if ( ! $is_logged_in && $current_page === 'subscription-not-activated' ) {
            Power::go_home();
        }

        // Prevent non admin and subscription activated activated users to go subscription not activated
        if ( $is_logged_in && $is_sub_active && $current_page === 'subscription-not-activated' && !$is_user_admin ) {
            Power::go_dashboard();
        }

    }

    /**
     * Redirect admins to admin login page after logout
     *
     * @param int $user_id
     * @return void
     */
    public function admin_logout( $user_id ) {
        $user = get_userdata( $user_id );

        if ( in_array( 'administrator', $user->roles ) ) {
            wp_redirect( site_url( 'admin' ), 301 );
            exit;
        }
    }
}