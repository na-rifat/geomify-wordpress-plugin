<?php

namespace geomify;

class Theme {
    public function __construct() {
        $this->register_hooks();
    }

    public function register_hooks() {
        add_action( 'wp_footer', [$this, 'jump_to_top'] );
    }

    public function jump_to_top() {
        printf( '<div class="jump-to-top"><i class="fas fa-arrow-up"></i></div>' );
    }
}