<?php

namespace geomify\Processor;

defined( 'ABSPATH' ) or exit;

use geomify\Processor\Processor as Processor;

class Power {
    function __construct() {

    }

    /**
     * Navigate current request to homepage
     *
     * @return void
     */
    public static function go_home() {
        wp_redirect( GEOMIFY_SITE_URL, 301 );
    }

    /**
     * Naviagte current request to dashboard page
     *
     * @return void
     */
    public static function go_dashboard() {
        if ( Processor::have_page( 'dashboard' ) ) {
            self::go( 'dashboard' );
            return;
        }

        self::go_home();
    }

    /**
     * Navigate current request to login page
     *
     * @return void
     */
    public static function go_login() {
        if ( Processor::have_page( 'login' ) ) {
            self::go( 'login' );
            return;
        }

        self::go_home();
    }

    /**
     * Logout current user
     *
     * @return void
     */
    public static function logout() {
        wp_logout();

        self::go_home();
    }

    /**
     * Navigate current request to a specific page
     *
     * @param  string  $slug
     * @param  integer $status
     * @return void
     */
    public static function go( $slug = '', $status = 301 ) {
        // if ( get_page_by_path( $slug ) === null ) {
        //     wp_redirect( GEOMIFY_SITE_URL, $status );
        //     return;
        // }

        wp_redirect( GEOMIFY_SITE_URL . '/' . $slug, $status );
        exit;
    }

    public static function login( $user, $password ) {

    }

    /**
     * Return current page slug
     *
     * @return string
     */
    public static function current_page() {
        global $post;
        return $post->post_name;
    }

    public static function current_parent() {
        global $post;
        $parent = get_post( $post->post_parent );
        return $parent !== null && $parent->post_name !== self::current_page() ? $parent->post_name : null;
    }

}