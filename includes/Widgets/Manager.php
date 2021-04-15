<?php

namespace geomify\Widgets;

class Manager {

    function __construct() {

    }

    function register_elementor_widgets() {
        /**
         * Geomify button
         */
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Items\Elementor\Button() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Items\Elementor\Videoplay() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Items\Elementor\Compare_table() );
    }
}