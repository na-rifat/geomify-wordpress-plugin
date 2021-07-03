<?php

namespace geomify\Widgets;

defined( 'ABSPATH' ) or exit;

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
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Items\Elementor\Video_button() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Items\Elementor\Price_card() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Items\Elementor\Multiform() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Items\Elementor\Dashboardmenu() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Items\Elementor\Iframe() );
    }
}