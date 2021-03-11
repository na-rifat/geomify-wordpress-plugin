<?php

namespace geomify;

class CRUD {
    function __construct() {

    }

    /**
     * Initializes the class
     *
     * Creates self schema object
     *
     * @return void
     */
    function init() {
        $schema       = new Schema();
        $this->schema = $schema;
    }

    /**
     * Creates an instance of database class
     *
     * @return mixed
     */
    public static function DB() {
        global $wpdb;
        return $wpdb;
    }

    /**
     * Inserts a new record in database
     *
     * @param  string       $table_name
     * @param  string       $schema_name
     * @return object|int
     */
    public function create( $table_name, $schema_name ) {
        $data      = $this->schema->collect_from_post( $schema_name );
        $data_type = Schema::data_col_type_schema( $this->schema->get( $schema_name ) );

        $insert_id = self::DB()->insert(
            $table_name,
            $data,
            $data_type
        );

        if ( is_wp_error( $insert_id ) ) {
            return new \WP_Error( 'crud-insert-failed', __( 'Failed to insert a record to the database', 'geomify' ), $data );
        }

        return $insert_id;
    }

    /**
     * Retrives data from database
     * 
     * Single retrieve supports
     * 
     * Multple retrieve supports
     *
     * @param string $table_name
     * @param string $single
     * @return mixed
     */
    public function retrieve( $table_name, $single ) {
        if ( ! $single ) {
            return self::DB()->get_results(
                self::DB()->prepare(
                    "SELECT * FROM %s",
                    $table_name
                )
            );
        } else {
            return self::DB()->get_row(
                self::DB()->prepare(
                    "SELECT * FROM %s",
                    $table_name
                )
            );
        }
    }

    public function update($table_name, $schema_name, $identifier_col) {

    }

    public function delete() {

    }

    public function list() {

    }

}