<?php

namespace geomify\Processor;

defined( 'ABSPATH' ) or exit;

use \geomify\Processor\Power as Power;
use \geomify\Processor\User as User;

class Redirect {
    function __construct() {
        add_action( 'template_redirect', [$this, 'redirect'] );
    }

    public function redirect() {
        $current_page       = Power::current_page();
        $is_logged_in       = is_user_logged_in();
        $current_user       = User::current_user();
        $current_user_id    = $current_user->ID;
        $is_activated       = get_user_meta( $current_user_id, 'activated', true );
        $activation         = isset( $_GET['user'] ) ? get_user_meta( $_GET['user'], 'activated', true ) : false;
        $current_roles      = User::current_user_roles();
        $current_user_roles = $current_roles == null ? [] : $current_roles;

        // Dashboard
        if ( $current_page === 'dashboard' ) {
            Power::go( 'dashboard/project-views' );
        }

        // if ( ! $is_logged_in && ! in_array( 'administrator', $current_user_roles ) ) {
        //     if ( $activation == false && $current_page != 'activation' ) {
        //         Power::go( 'dashboard/activation' );
        //     }

        //     // if ( isset( $_GET['action'] ) && $_GET['action'] == 'activate-user' && isset( $_GET['user'] ) && isset( $_GET['key'] ) && $is_logged_in == false ) {
        //     //     if ( $activation ) {
        //     //         Power::go( 'dashboard/project-views' );
        //     //     } else {
        //     //         exit( var_dump( $activation ) );
        //     //         // Power::go( sprintf( 'dashboard/activation?action=activate-user&user=%s&key=%s', $_GET['user'], $_GET['key'] ) );
        //     //         exit;
        //     //     }
        //     // }

        //     // exit( var_dump( $current_page ) );

        //     if ( $current_page == 'activation' && $activation ) {
        //         Power::go( 'dashboard/project-views' );
        //     }
        // }

        if ( $current_page == 'activation' && $activation == true ) {
            Power::go( 'dashboard/project-views' );
        }

        if ( isset( $_GET['action'] ) && $_GET['action'] == 'activate-user' && $current_page != 'activation' && isset( $_GET['user'] ) && isset( $_GET['key'] ) ) {
            Power::go( sprintf( 'activation?action=activate-user&user=%s&key=%s', $_GET['user'], $_GET['key'] ) );
        }
        if ( $is_logged_in && ( $current_page == 'sign-in' || $current_page == 'reset-password' ) ) {
            Power::go( 'dashboard' );
        }
    }
}