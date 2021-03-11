<?php

namespace geomify;

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
            'geomify-admin-script'    => geomify_jsfile( 'admin', ['jquery', 'elementor-frontend'] ),
            'geomify-frontend-script' => geomify_jsfile( 'frontend', ['jquery', 'elementor-frontend'] ),
            'geomify-widgets-script'  => geomify_jsfile( 'widgets', ['jquery'] ),
        ];
    }

    /**
     * Return styles from array
     *
     * @return array
     */
    public function get_styles() {
        return [
            'geomify-admin-styles'    => geomify_cssfile( 'admin' ),
            'geomify-frontend-styles' => geomify_cssfile( 'frontend' ),
            'geomify-widgets-styles'  => geomify_cssfile( 'widgets' ),
            'geomify-fontawesome'     => [
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
            'geomify-admin-script' => [
                'ajax_url' => admin_url( 'admin-ajax.php' ),
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
            'background'                  => 'rgb(3, 30, 43)',
            'background-light'            => 'rgb(1, 63, 117)',
        ];

        $vars = '';

        foreach ( $styles as $key => $val ) {
            $vars .= "--{$key}: {$val};";
        }

        echo "<style>:root{{$vars}}</style>";
    }
}