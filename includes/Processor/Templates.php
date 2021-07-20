<?php

namespace geomify\Processor;

/**
 * Name: Templates class
 *
 * Handles template parts
 *
 *
 *
 *
 *
 *
 * @author Rafalo tech <admin@rafalotech.com>
 *
 * @since 1.0.0
 */
class Templates {

    function __construct() {
        add_action('wp_footer', [$this, 'ck_consent']);
    }

    /**
     * Includes a template file
     *
     * @param  [type] $file
     * @return void
     */
    public function template( $file ) {
        ob_start();
        include GEOMIFY_TEMPLATES_PATH . "//{$file}.php";
        return ob_get_clean();
    }

    /**
     * Header template
     *
     * @return void
     */
    public function header() {
        return $this->template( 'header' );
    }

    /**
     * Footer template
     *
     * @return void
     */
    public function footer() {
        return $this->template( 'footer' );
    }

    public static function get( $path ) {
        ob_start();
        include GEOMIFY_TEMPLATES_PATH . "/{$path}.php";
        return ob_get_clean();
    }

    public static function _get( $path ) {
        echo self::get( $path );
    }

    public function ck_consent(){
        self::_get('cookies/consent');
    }

}