<?php

namespace geomify\Schema;

defined( 'ABSPATH' ) or exit;

class CRUD {
    public function __construct() {

    }

    public static function create() {

    }

    public static function retrieve() {

    }

    public static function update() {

    }

    public static function delete() {

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
}