<?php
/**
 * Geomify
 *
 *
 * @wordpress-plugin
 * Plugin Name:       Geomify
 * Plugin URI:        https://rafalotech.com/plugins/wp/geomify
 * Description:       Handles geomify functions
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Rafalo tech
 * Author URI:        https://rafalotech.com
 * Text Domain:       geomify
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 * @package           PluginPackage
 *
 * @author            Rafalo tech
 * @copyright         2021 Rafalo tech
 * @license           GPL-2.0-or-later
 */

namespace geomify;

use geomify\Admin\Admin;
use geomify\Processor\User;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once "vendor/autoload.php";

/**
 * Handles the Geomify plugin
 *
 * @author Rafalo tech <admin@rafalotech.com>
 */

class geomify {

    const info = [
        'name'        => 'Geomify',
        'text-domain' => 'geomify',
        'version'     => '1.0',
    ];

    function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, '\geomify\Activation::create_datatables' );
        register_activation_hook( __FILE__, '\geomify\Activation::create_folders' );

        add_action( 'plugins_loaded', [$this, 'init'] );
        add_action( 'elementor/elements/categories_registered', [$this, 'register_elementor_categories'] );

    }

    /**
     * Initializes the geomify sub classes and others
     *
     * @return void
     */
    public function init() {
        // Creation
        $templates  = new Processor\Templates();
        $shortcodes = new Processor\Shortcodes();
        $assets     = new Processor\Assets();
        $widgets    = new Widgets\Manager();
        $theme      = new Theme();
        $redirect   = new Processor\Redirect();
        $user       = new User();
        $stripe     = new Processor\Geomify_stripe();
        // Assignment
        $shortcodes->templates = $templates;

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            $ajax = new Processor\Ajax();
        }

        if ( is_admin() ) {
            $admin = new Admin();
        }

        // Initialization
        $shortcodes->init();

        add_action( 'elementor/widgets/widgets_registered', [$widgets, 'register_elementor_widgets'], 99 );

    }

    /**
     * Registers geomify category for elements section
     *
     * @return void
     */
    public function register_elementor_categories( $element_manager ) {
        $element_manager->add_category(
            'geomify',
            [
                'title' => __( 'Geomify', 'geomify' ),
                'icon'  => 'fab fa-google',
            ]
        );
        return $element_manager;
    }

    /**
     * Initialzies default wordpress categories
     *
     * @return void
     */
    public function init_wordpress_widgets() {

    }

    /**
     * Creates the instance of the class
     *
     * @return void
     */
    public static function create() {
        static $created = false;

        if ( ! $created ) {
            $created = new self();
        }
    }

    /**
     * Defines necessery constants
     *
     * @return void
     */
    public function define_constants() {
        $basedir = wp_upload_dir()['basedir'];
        $baseurl = wp_upload_dir()['baseurl'];

        define( 'GEOMIFY', __FILE__ );

        define( 'GEOMIFY_URL', plugins_url( '', GEOMIFY ) );
        define( 'GEOMIFY_PATH', __DIR__ );

        define( 'GEOMIFY_ASSETS_PATH', GEOMIFY_PATH . "//assets/" );
        define( 'GEOMIFY_CSS_PATH', GEOMIFY_ASSETS_PATH . "/css" );
        define( 'GEOMIFY_JS_PATH', GEOMIFY_ASSETS_PATH . "/js" );
        define( 'GEOMIFY_IMG_PATH', GEOMIFY_ASSETS_PATH . "/img" );
        define( 'GEOMIFY_TUTORIALS_PATH', $basedir . '/geomify/tutorials/' );
        define( 'GEOMIFY_TUTORIALS_URL', $baseurl . '/geomify/tutorials/' );
        define( 'GEOMIFY_FILES_DIR', $basedir . '/geomify/files/' );
        define( 'GEOMIFY_FILES_URL', $baseurl . '/geomify/files/' );

        define( 'GEOMIFY_ASSETS_URL', GEOMIFY_URL . "/assets/" );
        define( 'GEOMIFY_CSS_URL', GEOMIFY_ASSETS_URL . "/css/" );
        define( 'GEOMIFY_JS_URL', GEOMIFY_ASSETS_URL . "/js/" );
        define( 'GEOMIFY_IMG_URL', GEOMIFY_ASSETS_URL . "/img/" );

        define( 'GEOMIFY_TEMPLATES_PATH', GEOMIFY_PATH . "/templates/" );

        define( 'GEOMIFY_TEXT_DOMAIN', 'geomify' );
        define( 'GTD', GEOMIFY_TEXT_DOMAIN );
        define( 'GEOMIFY_RESOURCE_PATH', GEOMIFY_PATH . '/includes/resources/' );

        define( 'GEOMIFY_SITE_URL', site_url() );

    }

    /**
     * Returns plugin data
     *
     * @param  string         $key
     * @return object|array
     */
    public static function plugin_info( $key ) {
        return get_plugin_data( __FILE__ )[$key];
    }
}

// Create instance
function instance() {
    geomify::create();
}

instance();
