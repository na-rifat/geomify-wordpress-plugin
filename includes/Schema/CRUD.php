<?php

namespace geomify\Schema;

defined( 'ABSPATH' ) or exit;

use geomify\Processor\Data as Data;
use geomify\Processor\Processor as Processor;
use geomify\Schema\Schema as Schema;

class CRUD {
    public function __construct() {

    }

    public static function create_from_post( $schema_name, $additional_fields = [] ) {
        $table_name = self::prefix() . $schema_name;

        // Collecting post data
        $data = Processor::collect_posted_data( $schema_name );

        // Error checking
        if ( is_wp_error( $data ) ) {
            return $data;
        }

        // Data type
        $data_type = Data::generate_data_col_type( $schema_name );

        // Additional fields
        if ( ! empty( $additional_fields ) ) {
            foreach ( $additional_fields as $name => $value ) {
                $data[$name] = $value;
            }
        }

        // Insert
        $insert_id = self::DB()->insert(
            $table_name,
            $data,
            $data_type
        );

        // Value return
        if ( ! $insert_id ) {
            return new \WP_Error( 'crud-insert-failed', __( 'Failed to insert a record to the database', GEOMIFY_TEXT_DOMAIN ), $data );
        }
        return self::DB()->insert_id;
    }

    public static function create( $table_name, $data ) {
        $format     = Data::generate_data_col_type( $table_name );
        $table_name = self::prefix() . $table_name;

        $insert_id = self::DB()->insert(
            $table_name,
            $data,
            $format
        );

        if ( ! $insert_id ) {
            return new \WP_Error( 'crud-insert-failed', __( 'Failed to isnert a record to the database', GTD ) );
        }

        return $insert_id;
    }

    /**
     * Retrieve record(s)
     *
     * @param  [type]         $table_name
     * @param  [type]         $id
     * @param  string         $indentity_col
     * @return array|object
     */
    public static function retrieve( $table_name, $id = null, $indentity_col = 'id' ) {
        $table_name = self::prefix() . $table_name;

        if ( $id != null ) {
            return self::DB()->get_results(
                self::DB()->prepare(
                    sprintf( 'SELECT * FROM %s WHERE %s=%s', $table_name, $indentity_col, $id )
                )
            );
        }

        return self::DB()->get_results(
            self::DB()->prepare(
                sprintf( 'SELECT * FROM %s', $table_name )
            )
        );
    }

    public static function get_row( $table_name, $id, $id_col_name = 'id') {
        $table_name = self::prefix() . $table_name;

        return self::DB()->get_row(
            self::DB()->prepare(
                "SELECT * FROM {$table_name} WHERE {$id_col_name}=%s", $_POST['id']
            )
        );
    }

    public static function update( $table_name, $data, $id, $id_col_name = 'id' ) {
        $schema_name = $table_name;
        $table_name  = self::prefix() . $table_name;
        $format      = Data::generate_data_col_type( $schema_name );

        self::DB()->update(
            $table_name,
            $data,
            $format,
            [$id_col_name => $id]
        );
    }

    public static function update_from_post( $table_name, $id, $id_col_name = 'id' ) {
        $schema_name = $table_name;
        $table_name  = self::prefix() . $table_name;
        $format      = Data::generate_data_col_type( $schema_name );
        $data        = Processor::collect_posted_data( $schema_name );        

        $updated = self::DB()->update(
            $table_name,
            $data,
            [$id_col_name => $id],
            $format
        );

        if ( ! $updated ) {
            return new \WP_Error( 'update-failed', __( 'Failed to update', GTD ) );
        }

        return $updated;
    }

    public static function delete( $table_name, $id, $id_col_name = 'id' ) {
        $table_name = self::prefix() . $table_name;
        self::DB()->delete(
            $table_name,
            [$id_col_name => $id]
        );
    }

    public static function DB() {
        global $wpdb;
        return $wpdb;
    }

    public static function prefix() {
        return self::DB()->prefix;
    }

    public static function charset_collate() {
        return self::DB()->charset_collate;
    }

    public static function create_datatable( $table_name, $schema_name, $primary_key = 'id' ) {
        $schema = self::generate_datatable_schema( $table_name, $schema_name, $primary_key );

        if ( ! function_exists( 'dbDelta' ) ) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        dbDelta( $schema );
    }

    public static function generate_datatable_schema( $table_name, $schema_name, $primary_key = 'id' ) {
        $schema = Schema::get( $schema_name );

        $prefix          = CRUD::DB()->prefix;
        $charset_collate = CRUD::DB()->get_charset_collate();

        $qry = "CREATE TABLE IF NOT EXISTS `{$prefix}{$table_name}` (
        `{$primary_key}` int(255) NOT NULL AUTO_INCREMENT, ";

        foreach ( $schema as $field => $val ) {
            $qry .= self::database_single_field_schema( $field, $val );
        }

        $qry .= "PRIMARY KEY (`{$primary_key}`) ) {$charset_collate}";

        return $qry;
    }

    /**
     * Creates single database field schema
     *
     * @param  [type] $schema
     * @return void
     */
    public static function database_single_field_schema( $field_name, $schema ) {
        $schema = self::merge_single_field_schema( $schema );

        $null = 'DEFAULT NULL';

        return "`{$field_name}` {$schema['data_type']} {$null}, ";
    }

    /**
     * Merge single field schema values
     *
     * @param  [type] $schema
     * @return void
     */
    public static function merge_single_field_schema( $schema ) {
        $defaults = [
            'title'     => __( 'Input field', GTD ),
            'type'      => 'text',
            'data_type' => 'longtext',
            'required'  => false,
            'options'   => [],
            'class'     => [],
            'value'     => '',
        ];

        return wp_parse_args( $schema, $defaults );
    }
}