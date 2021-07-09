<?php

namespace geomify\Processor;

defined( 'ABSPATH' ) or exit;

use \geomify\Processor\User as User;

/**
 * Registers essential assets
 */
class Assets {
    /**
     * Construct assets class
     */
    function __construct() {
        add_action( 'wp_enqueue_scripts', [$this, 'register'] );
        add_action( 'admin_enqueue_scripts', [$this, 'register'] );
        add_action( 'wp_enqueue_scripts', [$this, 'load'] );
        add_action( 'admin_enqueue_scripts', [$this, 'load'] );
        add_action( 'wp_head', [$this, 'colors'] );
        add_action( 'admin_head', [$this, 'colors'] );
    }

    /**
     * Initializes the class
     *
     * @return void
     */
    public function init() {

    }

    /**
     * Return scripts from array
     *
     * @return array
     */
    public function get_scripts() {
        return [
            'geomify-universal-script' => geomify_jsfile( 'universal', ['jquery'] ),
            'geomify-admin-script'     => geomify_jsfile( 'admin', ['jquery', 'geomify-universal-script'] ),
            'geomify-frontend-script'  => geomify_jsfile( 'frontend', ['jquery', 'geomify-universal-script'] ),
            'geomify-widgets-script'   => geomify_jsfile( 'widgets', ['jquery', 'elementor-frontend'] ),
        ];
    }

    /**
     * Return styles from array
     *
     * @return array
     */
    public function get_styles() {
        return [
            'geomify-universal-styles' => geomify_cssfile( 'universal' ),
            'geomify-admin-styles'     => geomify_cssfile( 'admin' ),
            'geomify-frontend-styles'  => geomify_cssfile( 'frontend' ),
            'geomify-widgets-styles'   => geomify_cssfile( 'widgets' ),
            'geomify-fontawesome'      => [
                'src'     => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css',
                'version' => '5.15.2',
            ],
        ];
    }

    /**
     * Return localize variable from array
     *
     * @return array
     */
    public function get_localize() {
        return [
            'geomify-admin-script'    => [
                'ajax_url'                  => admin_url( 'admin-ajax.php' ),
                'new_tutorial_page_nonce'   => wp_create_nonce( 'new_tutorial_page' ),
                'new_tutorial_nonce'        => wp_create_nonce( 'new_tutorial' ),
                'get_admin_tutorials_nonce' => wp_create_nonce( 'get_admin_tutorials' ),
                'delete_tutorial_nonce'     => wp_create_nonce( 'delete_tutorial' ),
            ],
            'geomify-frontend-script' => [
                'site_url'                          => site_url(),
                'is_user_logged'                    => User::is_logged(),
                'ajax_url'                          => admin_url( 'admin-ajax.php' ),
                'logo_url'                          => GEOMIFY_ASSETS_URL . '/img/logo.png',
                'went_wrong'                        => __( 'Something went wrong', 'geomify' ),
                'new_pv_form_page_nonce'            => wp_create_nonce( 'get_new_pv_form' ),
                'new_pv_nonce'                      => wp_create_nonce( 'new_pv' ),
                'get_pv_nonce'                      => wp_create_nonce( 'get_pv' ),
                'get_dashboard_tutorial_list_nonce' => wp_create_nonce( 'get_dashboard_tutorial_list' ),
                'create_space_nonce'                => wp_create_nonce( 'create_space' ),
                'activate_user_nonce'               => wp_create_nonce( 'activate_user_finally' ),
                'get_registration_form_nonce'       => wp_create_nonce( 'get_registration_form' ),
                'save_ac_info_nonce'                => wp_create_nonce( 'save_ac_info' ),
                'subscriptions'                     => User::current_user_meta( 'stripe_subscriptions' ),
                'is_logged_in'                      => User::is_logged(),
                'upgrade_license_page_nonce'        => wp_create_nonce( 'upgrade_license_page' ),
                'stripe_payment_nonce'              => wp_create_nonce( 'stripe_payment' ),
                'stripe_upgrade_nonce'              => wp_create_nonce( 'stripe_upgrade' ),
                'submit_enterprise_quote_nonce'     => wp_create_nonce( 'submit_enterprise_quote' ),
                'file_info_submit_nonce'            => wp_create_nonce( 'file_info_submit' ),
                'upload_geo_files_nonce'            => wp_create_nonce( 'upload_geo_files' ),
                'remove_pm_nonce'                   => wp_create_nonce( 'remove_pm' ),
                'dlt_pv_nonce'                      => wp_create_nonce( 'dlt_pv' ),
                'update_pv_nonce'                   => wp_create_nonce( 'update_pv' ),
                'start_basic_form_nonce'                   => wp_create_nonce( 'start_basic_form' ),
                'start_basic_nonce'                   => wp_create_nonce( 'start_basic' ),
            ],
        ];
    }

    /**
     * Registers scripts, styles and localize variables
     *
     * @return void
     */
    public function register() {
        // Scripts
        $scripts = $this->get_scripts();

        foreach ( $scripts as $handle => $script ) {
            $deps = isset( $script['deps'] ) ? $script['deps'] : false;

            wp_register_script( $handle, $script['src'], $deps, ! empty( $script['version'] ) ? $script['version'] : false, true );

        }

        // Styles
        $styles = $this->get_styles();

        foreach ( $styles as $handle => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;

            wp_register_style( $handle, $style['src'], $deps, ! empty( $style['version'] ) ? $style['version'] : false );
        }

        // Localization
        $localize = $this->get_localize();

        foreach ( $localize as $handle => $vars ) {
            wp_localize_script( $handle, 'geomify', $vars );
        }
    }

    /**
     * Loads the scripts to frontend
     *
     * @return void
     */
    public function load() {
        wp_enqueue_style( 'geomify-fontawesome' );
        wp_enqueue_style( 'geomify-universal-styles' );
        wp_enqueue_script( 'geomify-universal-script' );

        if ( is_admin() ) {
            wp_enqueue_style( 'geomify-admin-styles' );
            wp_enqueue_script( 'geomify-admin-script' );
        } else {
            wp_enqueue_style( 'geomify-frontend-styles' );
            wp_enqueue_style( 'geomify-widgets-styles' );
            wp_enqueue_script( 'geomify-frontend-script' );
        }
    }

    /**
     * Loads colors
     *
     * @return void
     */
    public function colors() {
        $styles = [
            'text-button-color'           => '#ccc',
            'text-button-hover-color'     => '#fff',
            'menu-text-color'             => '#ccc',
            'menu-text-hover-color'       => '#fff',
            // Default
            'logo-color'                  => '#fff',
            'header-background-color'     => 'rgb(1, 41, 75)',
            'footer-background-color'     => 'rgb(1, 41, 75)',
            'geomify-transition'          => 'all 0.2s linear',
            'color'                       => '#fff',
            'hover-color'                 => '#ccc',
            // Buttons
            'btn1-color'                  => '#fff',
            'btn1-background-color'       => '#0aaff1',
            'btn1-hover-background-color' => 'rgb(4, 142, 197)',
            // Texts
            'link-color'                  => '#fff',
            'link-hover-color'            => '#ccc',
            'text-color'                  => '#fff',
            // Background
            'background'                  => '#212221',
            'background-light'            => '#FFFFFF',
            'cyan'                        => '#51a7f9',
            'geomify-white-logo'          => GEOMIFY_ASSETS_URL . '/img/logo.png',
        ];

        $vars = '';

        foreach ( $styles as $key => $val ) {
            $vars .= "--{$key}: {$val};";
        }

        echo "<style>:root{{$vars}}</style>";

        $subscriptions = (array) User::get_meta( 'stripe_subscriptions' );
        $sub_styles    = '<style>';
        foreach ( $subscriptions as $subscription ) {
            $sub_styles .= sprintf( '.upgrade-panel-%s{display: none;}', $subscription );
        }
        $sub_styles .= '</style>';

        echo $sub_styles;
    }
}