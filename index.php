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
 * @package           PluginPackage
 *
 * @author            Rafalo tech
 * @copyright         2021 Rafalo tech
 * @license           GPL-2.0-or-later
 */

namespace geomify;
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
        $templates  = new Templates();
        $shortcodes = new Shortcodes();
        $assets     = new Assets();
        $widgets    = new Widgets\Manager();
        // Assignment
        $shortcodes->templates = $templates;

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
        $created = false;

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
        define( 'GEOMIFY', __FILE__ );

        define( 'GEOMIFY_URL', plugins_url( '', GEOMIFY ) );
        define( 'GEOMIFY_PATH', __DIR__ );

        define( 'GEOMIFY_ASSETS_PATH', GEOMIFY_PATH . "//assets/" );
        define( 'GEOMIFY_CSS_PATH', GEOMIFY_ASSETS_PATH . "//css" );
        define( 'GEOMIFY_JS_PATH', GEOMIFY_ASSETS_PATH . "//js" );
        define( 'GEOMIFY_IMG_PATH', GEOMIFY_ASSETS_PATH . "//img" );

        define( 'GEOMIFY_ASSETS_URL', GEOMIFY_URL . "//assets/" );
        define( 'GEOMIFY_CSS_URL', GEOMIFY_ASSETS_URL . "//css" );
        define( 'GEOMIFY_JS_URL', GEOMIFY_ASSETS_URL . "//js" );
        define( 'GEOMIFY_IMG_URL', GEOMIFY_ASSETS_URL . "//img" );

        define( 'GEOMIFY_TEMPLATES_PATH', GEOMIFY_PATH . "//templates/" );
    }
}

// Create instance
function instance() {
    geomify::create();
}

instance();
