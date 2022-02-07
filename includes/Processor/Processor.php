<?php

namespace geomify\Processor;

defined('ABSPATH') or exit;

use geomify\Processor\Power as Power;
use geomify\Processor\User as User;
use geomify\Schema\Schema as Schema;

class Processor
{
    function __construct()
    {
        $this->register_hooks();
    }

    /**
     * Register action and filter hooks
     *
     * @return void
     */
    public function register_hooks()
    {
        add_action('wp_head', [$this, 'analytic_script']);
    }

    /**
     * Inject google analytical script
     *
     * @return void
     */
    public function analytic_script()
    {
?>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-XFBNWY9XBB"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'G-XFBNWY9XBB');
        </script>

<?php
    }

    /**
     * Converts a text file to array
     *
     * separated with new lines
     *
     * @param  string  $file_path
     * @param  boolean $single_col
     * @return array
     */
    public static function txtfile2array($file_path, $single_col = false, $separator = PHP_EOL)
    {
        if (!file_exists($file_path) || filesize($file_path) == 0) {
            return [];
        }

        $file = fopen($file_path, 'r');
        $string = fread($file, filesize($file_path));

        fclose($file);

        $items  = explode($separator, $string);
        $result = [];

        if (!$single_col) {
            foreach ($items as $item) {
                $result[$item] = $item;
            }
            return $result;
        }

        return $items;
    }

    /**
     * Creates input names from key
     *
     * @param  array   $schema
     * @return array
     */
    public static function add_name_to_inputs($schema)
    {
        $result = [];

        foreach ($schema as $key => $props) {
            $result[$key]         = $props;
            $result[$key]['name'] = $key;
        }

        return $result;
    }

    /**
     * Check if an specific page exists
     *
     * @param  string $title
     * @return bool
     */
    public static function have_page($title)
    {
        if (get_page_by_title($title) !== null) {
            return true;
        }

        return false;
    }

    /**
     * Assign input fields name to schema
     *
     * @param  array   $schema
     * @return array
     */
    public static function assign_names_to_schema($schema)
    {
        foreach ($schema as $key => $props) {
            $schema[$key]['name'] = $key;
            $schema[$key]['id']   = $key;
        }

        return $schema;
    }

    /**
     * Collected posted data by matching with a pre defined schema from global POST array
     *
     * @param String $schema_name
     * @return Array
     */
    public static function collect_posted_data($schema_name)
    {
        $schema = Schema::get($schema_name);
        $data   = [];

        foreach ($schema as $key => $props) {
            if ($props['hidden'] == true) {
                continue;
            }

            if ($props['type'] === 'checkbox' && empty(geomify_var($key))) {
                $data[$key] = 0;
                continue;
            }

            if ($props['type'] === 'checkbox' && geomify_var($key) === '1') {
                $data[$key] = true;
                continue;
            }

            $data[$key] = geomify_var($key);
        }

        return $data;
    }

    /**
     * Get value only from a schema
     *
     * @param Array $schema
     * @param Array|NULL $values
     * @return void
     */
    public static function seperate_values_from_schema(array $schema,  array $values = null)
    {
        $result = [];

        if (!$values == null) {
            foreach ($schema as $field => $props) {
                if (!isset($values[$field])) {
                    continue;
                }

                $result[$field] = $values[$field];
            }

            return $result;
        }

        foreach ($schema as $field => $props) {
            if (!isset($props['value'])) {
                continue;
            }

            $result[$field] = $props['value'];
        }

        return $result;
    }

    /**
     * Add additional key => value pair to an existed schema
     *
     * @param  Array   $schema
     * @param  Array   $values
     * @return Array 
     */
    public static function add_values_to_schema($schema, $values = [])
    {
        if ($values == false) {
            return $schema;
        }

        if (gettype($values) == 'object') {
            $values = std2array($values);
        }

        foreach ($schema as $key => $props) {
            if (!isset($values[$key])) {
                continue;
            }

            $schema[$key]['value'] = $values[$key];
        }

        return $schema;
    }


    /**
     * Get users current package information
     *
     * @param String $package_name
     * @return Array|String
     */
    public static function get_user_package_info(String $package_name)
    {
        $package_name = 'profile_' . $package_name;

        return get_user_meta(User::current_user_id(), $package_name, true);
    }

    /**
     * Merge package names to store in DB
     *
     * @param String $package_name
     * @param Array $new
     * @return array
     */
    public static function merge_package_info(String $package_name, array $new)
    {
        $package_name = 'profile_' . $package_name;

        $old = get_user_meta(User::current_user_id(), $package_name, true);
        $old = $old == false ? [] : $old;

        foreach ($new as $key => $value) {
            $old[$key] = $value;
        }

        return $old;
    }

    /**
     * Send manual license activation email to admin and the user
     *
     * @return void
     */
    public static function send_manual_license_email()
    {
        wp_mail(
            User::email(),
            'License subscription confirmation',
            Templates::get('email/header') . Templates::get('email/manual-activation-client') . Templates::get('email/manual-activation-footer'),
            [
                'Content-Type: text/html; charset=UTF-8',
                sprintf('From: %s <admin@geomify.com>', get_bloginfo('name')),
            ]
        );

        geo_mail('license@geomify.com', 'Manual license activation', 'manual-activation-admin', 'admin-header', 'admin-footer');
    }

    /**
     * Check if specified country listed in European Union
     *
     * @param String $country_name
     * @return boolean
     */
    public static function is_eu_country(String $country_name)
    {
        if (!$country_name) return false;
        $country_name = ucfirst(strtolower($country_name));
        $eu_countries = self::txtfile2array(GEOMIFY_RESOURCE_PATH . 'eu_countries.txt', true, ', ');

        return in_array($country_name, $eu_countries);
    }


    public static function country_code($country_name)
    {
        require_once GEOMIFY_RESOURCE_PATH . 'country_list.php';

        $country_name = ucfirst(strtolower($country_name));
        $country_list = array_flip($country_list);

        return isset($country_list[$country_name]) ? $country_list[$country_name] : false;
    }
}
