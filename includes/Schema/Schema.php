<?php

namespace geomify\Schema;

defined( 'ABSPATH' ) or exit;

/**
 * Schema management class
 */
class Schema {

    /**
     * Build the class
     */
    public function __construct() {

    }

    /**
     * Build the schema
     *
     * @return void
     */
    public function build() {
        $domain = 'geomify';

        $this->schema = [
            'settings'      => [
                'style' => [
                    'primary-color'   => [
                        'label' => __( 'Primary color', $domain ),
                        'value' => '',
                        'type'  => 'color',
                    ],
                    'secondary-color' => [
                        'label' => __( 'Secondary color', $domain ),
                        'value' => '',
                        'type'  => 'color',
                    ],
                    'transition'      => [
                        'label' => __( 'Transition', $domain ),
                        'value' => 'all .3s ease-in-out',
                        'type'  => 'text',
                    ],
                ],
            ],
            'site_settings' => [
                'enable-jump-top' => [
                    'label' => __( 'Enable jump to top', $domain ),
                    'type'  => 'radio',
                    'value' => 'enabled',
                ],
            ],
        ];

        $this->schema['allowed_shortcodes'] = [
            '[contact-form-7 id="593" title="Plant & Process"]',
            '[contact-form-7 id="735" title="Contact us"]',
        ];
    }

    /**
     * Returns a schema
     *
     * @param  string         $schema_name
     * @return array|object
     */
    public static function get( $schema_name ) {
        $self = new self();
        return $self->schema[$schema_name];
    }

    /**
     * Returns a settings
     *
     * @param  [type] $settings_name
     * @return void
     */
    public static function get_settings( $settings_name ) {
        $core    = self::get( 'settings' )[$settings_name];
        $current = get_option( self::settings_name_encode( $settings_name ), $core );

        foreach ( $core as $single => $prop ) {
            if ( ! isset( $current[$single] ) ) {
                $current[$single] = $prop;
            }
        }

        if ( sizeof( $current ) !== sizeof( $core ) ) {
            update_option( self::settings_name_encode( $settings_name ), $current );
        }

        return $current;
    }

    /**
     * Save a setting
     *
     * @param  string       $settings_name
     * @param  array|object $settings
     * @return void
     */
    public static function set_settings( $settings_name, $settings ) {
        $schema = self::get( 'settings' )[$settings_name];

        foreach ( $schema as $name => $prop ) {
            if ( ! isset( $settings[$name] ) ) {
                continue;
            }

            $schema[$name]['value'] = $settings[$name];
        }

        update_option( self::settings_name_encode( $settings_name ), $schema );
    }

    /**
     * Encoded name of setting
     *
     * @param  string   $settings_name
     * @return string
     */
    public static function settings_name_encode( $settings_name ) {
        return sprintf( 'geomify-settings-%s', $settings_name );
    }

    /**
     * Decoded name of setting
     *
     * @param  string   $settings_name
     * @return string
     */
    public static function settings_name_decode( $settings_name ) {
        return str_replace( 'geomify-settings', '', $settings_name );
    }

    /**
     * Reset all settings to default
     *
     * @return void
     */
    public static function reset_settings() {
        $settings = self::get( 'settings' );

        foreach ( $settings as $name => $prop ) {
            update_option( self::settings_name_encode( $name ), $prop );
        }
    }

}