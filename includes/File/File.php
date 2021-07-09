<?php

namespace geomify\File;

class File {

    function __construct() {

    }

    /**
     * Initializes the class
     *
     * @return void
     */
    public function init() {

    }

    public static function get_info( $file, $atts = [] ) {
        $defaults = [
            'dir' => GEOMIFY_FILES_DIR,
            'url' => GEOMIFY_FILES_URL,
        ];

        $atts = wp_parse_args( $atts, $defaults );

        $result = [];

        $result['tmp_name']     = $file['tmp_name'];
        $result['upload_name']  = $file['name'];
        $result['type']         = $file['type'];
        $result['size']         = $file['size'];
        $result['ext']          = strtolower( explode( '.', $file['name'] )[sizeof( explode( '.', $file['name'] ) ) - 1] );
        $result['name']         = explode( '.', $file['name'] )[0];
        $result['storage_name'] = wp_unique_filename( $atts['dir'], $result['name'] . '.' . $result['ext'] );
        $result['dir']          = str_replace( '\\', '/', $atts['dir'] . $result['storage_name'] );
        $result['url']          = $atts['url'] . $result['storage_name'];
        $result['uploaded_at']  = time();

        return $result;
    }

    public static function move( $file ) {
        move_uploaded_file( $file['tmp_name'], $file['dir'] );
    }
}