<?php
namespace geomify;

class Schema {
    const prefix     = 'geomify';
    const data_types = [
        's' => ['text', 'longtext', 'varchar'],
        'd' => ['number'],

    ];
    function __construct() {

    }

    /**
     * Builds the initial schemas
     *
     * @return void
     */
    public function __build() {
        $this->allowed_ajax_shortcodes = [
            'plant_and_process_contact_form'
        ];
    }

    /**
     * Stores a Schema in database
     *
     *
     * @param  string $name
     * @param  array  $schema
     * @return void
     */
    public static function set( $name, $schema ) {
        update_option( self::prefix . $name, $schema );
    }

    /**
     * Returns database stored schama
     *
     * Default on empty in database
     *
     *
     * @param  string $name
     * @return void
     */
    public function get( $name ) {
        $schema = get_option( self::prefix, $this->$name );

        // Check for static changes
        if ( ! count( $schema ) == count( $this->$name ) ) {
            foreach ( $schema as $key => $value ) {
                if ( ! isset( $this->$name[$key] ) ) {
                    array_push( $schema, $this->$name[$key] );
                }
            }
            self::set( $name, $schema );
        }

        return $schema;
    }

    /**
     * Returns static schema
     *
     * Basically the core Array
     *
     * @param  [type] $name
     * @return void
     */
    public static function get_static_core( $name ) {
        $self = new self();
        return $self->$name;
    }

    /**
     * Returns a schema from database via static method
     *
     * @param  string  $name
     * @return mixed
     */
    public static function get_static( $name ) {
        $self = new self();
        return $self->get( $name );
    }

    /**
     * Collects schema data from POST method
     *
     * @param  [type] $schema
     * @return void
     */
    public static function collect_from_post( $name ) {
        $result = [];
        $schema = self::get_static( $name );

        foreach ( $schema as $key => $value ) {
            $result[$key] = isset( $_POST[$key] ) ? $_POST[$key] : '';
        }

        return $result;
    }

    /**
     * Builds database supported schema
     *
     * @return void
     */
    public function build_database_schema( $table_name, $schema, $primary_key = 'id' ) {

    }

    /**
     * Builds single column schema for database
     *
     * @param  [type] $name
     * @param  [type] $schema
     * @return void
     */
    public function build_data_col( $name, $schema ) {

    }

    /**
     * Creates input fields from schema
     *
     * @return void
     */
    public function create_input_fields( $form_name, $schema, $start = 0, $end = 0 ) {

    }

    /**
     * Converts columns to data type for SQL operations
     *
     * @return void
     */
    public static function data_col_type_schema( $schema ) {
        $result = [];

        foreach ( $schema as $key => $value ) {
            switch ( $value['data_type'] ) {
                case 'longtext':
                case 'text':
                case 'varchar':
                    $result[] = '%s';
                    break;
                case 'integer':
                case 'number':
                case 'int':
                case 'longint':
                    $result[] = '%d';
                    break;
                case 'float':
                case 'double':
                    $result[] = '%f';
                default:
                    $result[] = '%s';
                    break;
            }
        }

        return $result;
    }

}