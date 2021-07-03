<?php

namespace geomify\Processor;

defined( 'ABSPATH' ) or exit;

use geomify\Processor\Power as Power;
use geomify\Processor\User as User;
use geomify\Schema\Schema as Schema;

class Processor {
    function __construct() {

    }

    /**
     * Register action and filter hooks
     *
     * @return void
     */
    public function register_hooks() {
        add_action( 'template_redirect', [$this, 'user_redirect'] );
    }

    /**
     * User redirect management
     *
     * @return void
     */
    public function user_redirect() {
        if ( User::is_logged() ) {
            Power::go_dashboard();
            return;
        }

        Power::go_home();
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
    public static function txtfile2array( $file_path, $single_col = true ) {
        if ( ! file_exists( $file_path ) || filesize( $file_path ) == 0 ) {
            return [];
        }

        $file = fopen( $file_path, 'r' );
        // var_dump( filesize( $file_path ) );exit;
        $string = fread( $file, filesize( $file_path ) );
        fclose( $file );

        $items  = explode( PHP_EOL, $string );
        $result = [];

        if ( $single_col ) {
            foreach ( $items as $item ) {
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
    public static function add_name_to_inputs( $schema ) {
        $result = [];

        foreach ( $schema as $key => $props ) {
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
    public static function have_page( $title ) {
        if ( get_page_by_title( $title ) !== null ) {
            return true;
        }

        return false;
    }

    public static function assign_names_to_schema( $schema ) {
        foreach ( $schema as $key => $props ) {
            $schema[$key]['name'] = $key;
            $schema[$key]['id']   = $key;
        }

        return $schema;
    }

    public static function collect_posted_data( $schema_name ) {
        $schema = Schema::get( $schema_name );
        $data   = [];

        foreach ( $schema as $key => $props ) {
            $data[$key] = geomify_var( $key );
        }

        return $data;
    }

    public static function seperate_values_from_schema( $schema, $values = null ) {
        $result = [];

        if ( ! $values == null ) {
            foreach ( $schema as $field => $props ) {
                if ( ! isset( $values[$field] ) ) {
                    continue;
                }

                $result[$field] = $values[$field];
            }

            return $result;
        }

        foreach ( $schema as $field => $props ) {
            if ( ! isset( $props['vallue'] ) ) {
                continue;
            }

            $result[$field] = $props['value'];
        }

        return $result;
    }

    public static function add_values_to_schema( $schema, $values = [] ) {
        if ( $values == false ) {
            return $schema;
        }

        foreach ( $schema as $key => $props ) {
            if ( ! isset( $values[$key] ) ) {
                continue;
            }

            $schema[$key]['value'] = $values[$key];
        }

        return $schema;
    }

    public static function get_user_package_info( $package_name ) {
        $package_name = 'profile_' . $package_name;

        return get_user_meta( User::current_user_id(), $package_name, true );
    }

    public static function merge_package_info( $package_name, $new ) {
        $package_name = 'profile_' . $package_name;

        $old = get_user_meta( User::current_user_id(), $package_name, true );
        $old = $old == false ? [] : $old;

        foreach ( $new as $key => $value ) {
            $old[$key] = $value;
        }

        return $old;
    }

    

}