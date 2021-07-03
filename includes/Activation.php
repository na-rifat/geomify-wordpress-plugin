<?php

namespace geomify;

defined( 'ABSPATH' ) or exit;

use geomify\Schema\CRUD as CRUD;

class Activation {
    function __construct() {

    }

    public static function create_datatables() {
        CRUD::create_datatable( 'project_views', 'project_views' );
        CRUD::create_datatable( 'tutorials', 'tutorials' );
        CRUD::create_datatable( 'newsletter', 'newsletter' );
        CRUD::create_datatable( 'enterprise_quotes', 'enterprise_quotes' );
        CRUD::create_datatable( 'partner_programs_request', 'partner_programs_request' );
        CRUD::create_datatable( 'educational_institutes_requests', 'educational_institutes_requests' );
    }

    public static function create_folders() {
        $upload_dir = wp_upload_dir()['basedir'];

        $folders = [
            $upload_dir . '/geomify/tutorials',
            $upload_dir . '/geomify/files',
        ];

        foreach ( $folders as $folder ) {
            if ( ! file_exists( $folder ) ) {
                wp_mkdir_p( $folder );
            }
        }
    }
}