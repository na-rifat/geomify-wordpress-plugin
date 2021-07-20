<?php
defined( 'ABSPATH' ) or die( 'You can\'t access to this file' );
/**
 * This files contains all important functions for geomify wp plugin
 */

/**
 * Return a css files url
 *
 * @param  [type] $filename
 * @return void
 */
if ( ! function_exists( 'geomify_cssfile' ) ) {
    function geomify_cssfile( $filename, $deps = [] ) {
        return ['src' => GEOMIFY_CSS_URL . "/{$filename}.css", 'version' => geomify_cssversion( $filename ), 'deps' => $deps];
    }
}

/**
 * Return a js files url
 *
 * @param  [type] $filename
 * @return void
 */
if ( ! function_exists( 'geomify_jsfile' ) ) {
    function geomify_jsfile( $filename, $deps = [] ) {
        return ['src' => GEOMIFY_JS_URL . "/{$filename}.js", 'version' => geomify_jsversion( $filename ), 'deps' => $deps];
    }
}

/**
 * Return a image files url
 *
 * @param  [type] $filename
 * @return void
 */
if ( ! function_exists( 'geomify_imgfile' ) ) {
    function geomify_imgfile( $filename ) {
        return GEOMIFY_IMG_URL . "/$filename";
    }
}
/**
 * Return a image files url
 *
 * @param  [type] $filename
 * @return void
 */
if ( ! function_exists( 'geomify_icofile' ) ) {
    function geomify_icofile( $filename ) {
        return GEOMIFY_IMG_URL . "/icons/$filename";
    }
}

/**
 * Get js files version based on date modified
 *
 * @param  [type] $filename
 * @return void
 */
if ( ! function_exists( 'geomify_jsversion' ) ) {
    function geomify_jsversion( $filename ) {
        return filemtime( convert_path_slash( GEOMIFY_PATH . "/assets/js/{$filename}.js" ) );
    }
}
/**
 * Get css files version based on date modified
 *
 * @param  [type] $filename
 * @return void
 */
if ( ! function_exists( 'geomify_cssversion' ) ) {
    function geomify_cssversion( $filename ) {
        return filemtime( convert_path_slash( GEOMIFY_PATH . "/assets/css/{$filename}.css" ) );
    }
}

/**
 * Replaces back slashes with slashes from a files path
 *
 * @param  [type] $path
 * @return void
 */
if ( ! function_exists( 'convert_path_slash' ) ) {
    function convert_path_slash( $path ) {
        return str_replace( "\\", "/", $path );
    }
}

/**
 * Pulls a template from views folder
 *
 * @param  [type] $dir
 * @param  [type] $filename
 * @return void
 */
if ( ! function_exists( 'geomify_template' ) ) {
    function geomify_template( $dir, $filename ) {
        ob_start();
        include convert_path_slash( "{$dir}/views/{$filename}.php" );
        return ob_get_clean();
    }
}

if ( ! function_exists( 'geomify_admin_template' ) ) {
    /**
     * Returns a template for admin panel
     *
     * @param  [type] $dir
     * @param  [type] $filename
     * @return void
     */
    function geomify_admin_template( $dir, $filename ) {
        ob_start();
        include convert_path_slash( "{$dir}/views/{$filename}.php" );
        echo ob_get_clean();
        return;
    }
}

/**
 * get's google recaptcha response
 *
 * @param  [type] $recaptcha
 * @return void
 */
if ( ! function_exists( 'reCaptcha' ) ) {
    function reCaptcha( $recaptcha ) {
        $secret = get_option( 'geomify_captcha_secret' ) ? get_option( 'geomify_captcha_secret' ) : '';
        $ip     = $_SERVER['REMOTE_ADDR'];

        $postvars = array(
            "secret"   => $secret,
            "response" => $recaptcha,
            "remoteip" => $ip,
        );
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $ch  = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 10 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $postvars );
        $data = curl_exec( $ch );
        curl_close( $ch );

        return json_decode( $data, true );
    }
}

/**
 * Verifies if a function is okay or not
 *
 * @return void
 */
if ( ! function_exists( 'verify_geomify_captcha' ) ) {
    function verify_geomify_captcha() {
        $recaptcha = $_POST['g-recaptcha-response'];
        $res       = reCaptcha( $recaptcha );
        if ( ! $res['success'] ) {
            return true;
        } else {
            return false;
        }
    }
}

if ( ! function_exists( 'geomify_ajax' ) ) {
    /**
     * Registers an ajax hook
     *
     * @param  [type] $action
     * @param  array  $func
     * @return void
     */
    function geomify_ajax( $action, $func = [] ) {
        add_action( "wp_ajax_$action", $func );
        add_action( "wp_ajax_nopriv_$action", $func );
    }
}

if ( ! function_exists( 'geomify_var' ) ) {
    /**
     * Returns formatted variable
     *
     * @param  [type]                        $var
     * @return void|string|int|array|mixed
     */
    function geomify_var( $var ) {
        return isset( $_POST[$var] ) && ! empty( $_POST[$var] ) ? $_POST[$var] : '';
    }

    if ( ! function_exists( 'geomify_get_option' ) ) {
        function geomify_get_option( $key ) {
            return stripslashes( get_option( $key ) );
        }
    }
}

if ( ! function_exists( 'array2options' ) ) {
    function array2options( $array ) {
        $result = '';
        foreach ( $array as $item ) {
            $caption = ucwords( $item );
            $result .= "<option value='{$item}'>{$caption}</option";
        }
        return $result;
    }
}

if ( ! function_exists( 'std2array' ) ) {
    function std2array( $std ) {
        return json_decode( json_encode( $std ), true );
    }
}

if ( ! function_exists( 'geomify_compare_table_rows' ) ) {
    function geomify_compare_table_rows( $rows ) {
        $result   = '';
        $packages = [
            'package_free',
            'package_basic',
            'package_facilitator',
            'package_creator',
            'package_enterprise',
        ];

        foreach ( $rows as $key => $row ) {
            if ( strpos( $key, 'package_' ) === FALSE ) {
                continue;
            }

            $result .= sprintf( '<td>%s</td>', $row == 'enabled' ? '<i class="fas fa-check-square"></i>' : '<span class="ico-na">n/a</span>' );
        }

        return $result;
    }
}

if ( ! function_exists( 'geomify_y2embed' ) ) {
    function geomify_y2embed( $string ) {
        return preg_replace(
            "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
            "https://www.youtube.com/embed/$2",
            $string
        );

    }
}

// Post views management
function geomify_get_post_view() {
    $count = get_post_meta( get_the_ID(), 'post_views_count', true );
    return "$count views";
}

function geomify_set_post_view() {
    $key     = 'post_views_count';
    $post_id = get_the_ID();
    $count   = (int) get_post_meta( $post_id, $key, true );
    $count++;
    update_post_meta( $post_id, $key, $count );
}

function geomify_posts_column_views( $columns ) {
    $columns['post_views'] = 'Views';
    return $columns;
}

function geomify_posts_custom_column_views( $column ) {
    if ( $column === 'post_views' ) {
        echo geomify_get_post_view();
    }
}

add_filter( 'manage_posts_columns', 'geomify_posts_column_views' );
add_action( 'manage_posts_custom_column', 'geomify_posts_custom_column_views' );

if ( ! function_exists( 'geomify_color_value' ) ) {
    /**
     * Hex encoded color value
     *
     * @param  string   $value
     * @return string
     */
    function geomify_color_value( $value ) {
        if ( strpos( $value, 'value' ) !== FALSE ) {
            $value = str_replace( ')', '', str_replace( '(', '', str_replace( 'value', '', $value ) ) );
            $value = explode( ', ', $value );
            $hex   = sprintf( "#%02x%02x%02x", $value[0], $value[1], $value[2] );

            return $hex;
        } else {
            $hex = $value;
            if ( strlen( $hex ) == 4 ) {
                $hex = '#' . str_replace( '#', '', $hex ) . str_replace( '#', '', $hex );
            }

            return $hex;
        }
    }
}

if ( ! function_exists( 'geomify_brand_logo' ) ) {
    /**
     * Get a image file url
     *
     * @return string
     */
    function geomify_brand_logo() {
        echo geomify_imgfile( 'logo.png' );
    }
}

if ( ! function_exists( 'geo_sanit' ) ) {
    function geo_sanit( $value ) {
        if ( $value == null or empty( $value ) ) {
            return __( 'null', GTD );
        }

        return $value;
    }
}

if ( ! function_exists( 'geomify_annual_price' ) ) {
    function geomify_annual_price( $monthly_price ) {
        return $monthly_price * 12;
    }
}

if ( ! function_exists( 'geomify_monthly_price' ) ) {
    function geomify_monthly_price( $annual_price ) {
        return $annual_price / 12;
    }
}

if ( ! function_exists( 'geomify_cesium_icon' ) ) {
    function geomify_cesium_icon( $width = 50, $height = 50 ) {
        return sprintf(
            '<img src="%s" alt="Cesium icon" style="width: %spx; height: %spx;" />',
            geomify_imgfile( 'cesium_icon.png' ),
            $width,
            $height
        );
    }
}

if ( ! function_exists( 'geomify_osm_icon' ) ) {
    function geomify_osm_icon( $width = 50, $height = 50 ) {
        return sprintf(
            '<img src="%s" alt="OSM icon" style="width: %spx; height: %spx;" />',
            geomify_imgfile( 'osm_icon.png' ),
            $width,
            $height
        );
    }
}

if ( ! function_exists( 'geo_session' ) ) {
    function geo_session() {
        if ( session_status() == PHP_SESSION_NONE ) {
            session_start();
        }
    }
}

if ( ! function_exists( 'geo_unique_username' ) ) {
    function geo_unique_username( $username ) {

        $username = explode( '@', $username )[0];

        $username = sanitize_user( $username );

        static $i;
        if ( null === $i ) {
            $i = 1;
        } else {
            $i++;
        }
        if ( ! username_exists( $username ) ) {
            return $username;
        }
        $new_username = sprintf( '%s-%s', $username, $i );
        if ( ! username_exists( $new_username ) ) {
            return $new_username;
        } else {
            return call_user_func( __FUNCTION__, $username );
        }
    }
}

if ( ! function_exists( 'geo_mail' ) ) {
    function geo_mail( $to, $subject, $template_name ) {
        $templates = new \geomify\Processor\Templates;
        wp_mail(
            $to,
            $subject, 
            $templates::get( 'email/header' ) . $templates::get("email/{$template_name}") . $templates::get( 'email/footer' ),
            [
                'Content-Type: text/html; charset=UTF-8',
                sprintf( 'From: %s <noreply@geomify.com>', get_bloginfo( 'name' ) ),
            ] );

    }
}