<?php

namespace geomify\File;
use geomify\Schema\CRUD;
use geomify\Schema\Schema;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . '/wp-admin/includes/class-wp-list-table.php';
}

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . '/wp-admin/includes/class-wp-list-table.php';
}

class Geolist extends \WP_List_Table {
    function __construct() {
        parent::__construct( [
            'singular' => 'Geo file',
            'plural'   => 'Geo files',
            'ajax'     => false,
        ] );
    }

    /**
     * Get columns
     *
     * @return void
     */
    function get_columns() {
        $schema             = Schema::get( 'geo_files_info' );
        $cols['first_name'] = $schema['first_name'];
        $cols['user_email'] = $schema['user_email'];
        $cols['company']    = $schema['company'];
        $cols['country']    = $schema['country'];
        $cols['created_at'] = $schema['created_at'];
        $cols['action']     = [
            'label' => __( 'Action' ),
        ];

        foreach ( $cols as $col => $props ) {
            unset( $cols[$col] );
            $cols[$col] = $props['label'];
        }

        return $cols;
    }

    /**
     * Sortable columns list
     *
     * @return void
     */
    function get_sortable_columns() {
        $sortable_columns = [

        ];
        return $sortable_columns;
    }

    /**
     * Formats and sends default comments
     *
     * @param  [type] $item
     * @param  [type] $column_name
     * @return void
     */
    protected function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'action':
                $id = $item->id;
                $url = admin_url( "admin.php?page=geomify-files&action=view&id={$item->id}" );
                return "<a href='{$url}' data-id='$id' class='button button-large view-geo-file'><i class='fas fa-eye'></i></a>&nbsp;<a href='#' data-id='$id' class='button button-large dlt-geo-file'><i class='fas fa-trash-alt'></i></a>";
                break;
            case 'created_at':
                return date( 'd/m/Y', $item->created_at );
                break;
            default:
                return esc_html( isset( $item->$column_name ) ? $item->$column_name : '' );
                break;
        }
    }

    /**
     * Prepares items
     *
     * @return void
     */
    public function prepare_items() {
        $column   = $this->get_columns();
        $hidden   = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array( $column, $hidden, $sortable );

        $this->items = $this->get_file_info();

        $this->set_pagination_args( array(
            'total_items' => count( $this->items ),
            'per_page'    => 20,
        ) );
    }

    /**
     * Generates content for a single row of the table.
     *
     *
     * @param object|array $item The current item
     */
    public function single_row( $item ) {
        echo "<tr>";
        $this->single_row_columns( $item );
        echo '</tr>';
    }

    /**
     * Gets transaction list from API
     *
     * @return void
     */
    function get_file_info() {
        return CRUD::retrieve( 'geo_files_info' );
    }

    /**
     * Creates the list
     *
     * @param  [type] $list
     * @return void
     */
    public static function _show() {
        $list = new self();
        $list->prepare_items();
        $list->display();
    }

}