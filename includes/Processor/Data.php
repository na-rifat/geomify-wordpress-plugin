<?php

namespace geomify\Processor;

defined( 'ABSPATH' ) or exit;

use geomify\Processor\Processor as Processor;
use geomify\Schema\Schema as Schema;

class Data {
    function __construct() {

    }

    /**
     * Collect posted data from frontend
     * 
     * Works from schema paramter
     *
     * @param string $schema_name
     * @return array
     */
    public static function collect_posted( $schema_name ) {
        $schema = Schema::get( $schema_name );

        foreach ( $schema as $key => $props ) {
            if ( isset( $_POST[$key] ) ) {
                $schema[$key]['value'] = $_POST[$key];
                continue;
            }
            $schema[$key]['value'] = '';
        }

        return $schema;
    }

    /**
     * Generate data column type for database operations
     * 
     * Works from schema parameter
     *
     * @param string $schema_name
     * @return array
     */
    public static function generate_data_col_type( $schema_name ) {
        $schema = Schema::get( $schema_name );

        $result = [];

        foreach ( $schema as $key => $value ) {
            if ( $value['hidden'] == true ) {
                continue;
            }
            
            switch ( $value['data_type'] ) {
                case 'longtext':
                case 'text':
                case 'varchar':
                    $result[] = '%s';
                    break;
                case 'integer':
                case 'number':
                case 'int':
                case 'biggint':
                    $result[] = '%d';
                    break;
                case 'float':
                case 'double':
                    $result[] = '%f';
                    break;
                default:
                    $result[] = '%s';
                    break;
            }
        }

        return $result;
    }
}