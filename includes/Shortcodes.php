<?php

namespace geomify;

class Shortcodes {

    function __construct() {

    }
    
    function register() {
        add_shortcode( 'geomify-header', [$this->templates, 'header'] );
        add_shortcode( 'geomify-footer', [$this->templates, 'footer'] );
    }

    function init(){
        $this->register();
    }
}