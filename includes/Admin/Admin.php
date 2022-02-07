<?php

namespace geomify\Admin;

defined( 'ABSPATH' ) or exit;

use geomify\Processor\Templates as Templates;

class Admin {
    function __construct() {
        add_action( 'admin_menu', [$this, 'register_menus'] );
    }

    /**
     * Initializes the class
     *
     * @return void
     */
    public function init() {
    }

    public function register_menus() {
        $parent_slug = 'geomify';
        $capability  = 'manage_options';
        add_menu_page( __( 'Geomify', GTD ), __( 'Geomify', GTD ), $capability, 'geomify', [$this, 'index_page'], 'dashicons-admin-site-alt3', 2 );
        add_submenu_page( $parent_slug, __( 'Options', GTD ), __( 'Options', GTD ), $capability, $parent_slug, [$this, 'index_page'] );
        add_submenu_page( $parent_slug, __( 'Tutorials', GTD ), __( 'Tutorials' ), $capability, 'geomify-tutorials', [$this, 'tutorials_page'] );
        add_submenu_page( $parent_slug, __( 'Geo files', GTD ), __( 'Geo files' ), $capability, 'geomify-files', [$this, 'geo_files'] );
    }

    public function index_page() {
        Templates::_get( 'admin/options' );
    }

    public function tutorials_page() {
        Templates::_get( 'admin/tutorials/index' );
    }

    public function geo_files() {
        Templates::_get( 'admin/geo-files/index' );
    }
}