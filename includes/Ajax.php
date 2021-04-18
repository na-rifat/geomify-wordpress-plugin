<?php

namespace geomify;
use geomify\Schema\Schema as Schema;

class Ajax {

    function __construct() {

    }

    /**
     *
     *
     * @return void
     */
    public function init() {

    }

    /**
     * Registers ajax requests
     *
     * @return void
     */
    public function register() {
        geomify_ajax( 'get_shortcode', [$this, 'get_shortcode'] );
    }

    /**
     * Returns shortcodes to ajax request
     *
     * @return void
     */
    public function get_shortcode() {

        if ( ! in_array( geomify_var( 'shortcode' ), Schema::get( 'allowed_shortcodes' ) ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Requested shortcode isn\'t allowed for use from AJAX', 'geomify' ),
                ]
            );
            exit;
        }
        wp_send_json_success(
            [
                'shortcode' => do_shortcode( geomify_var( 'shortcode' ) ),
            ]
        );

        exit;
    }
}