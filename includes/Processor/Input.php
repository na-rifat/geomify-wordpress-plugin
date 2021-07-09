<?php

namespace geomify\Processor;

defined( 'ABSPATH' ) or exit;

class Input {
    function __construct() {

    }

    /**
     * Start the form
     *
     * @param [type] $args
     * @return void
     */
    public static function start( $args ) {
        $defaults = [

        ];

        printf(
            '<form action="%s" method="%s" class="%s" id="%s">',
            $args['action'],
            $args['method'],
            explode( ' ', $args['class'] ),
            $args['id']
        );
    }

    /**
     * Create row of field
     *
     * @param  array  $args
     * @return void
     */
    public static function create_field( $args ) {
        printf(
            '<div class="geomify-form-input-group">%s</div>',
            self::create_input( $args )
        );
    }

    /**
     * Creates row of fields pair
     *
     * @param  array  $args1
     * @param  array  $args2
     * @return void
     */
    public static function create_field_pair( $args1, $args2 ) {
        printf(
            '<div class="geomify-form-input-group pair-group">%s%s</div>',
            self::create_input( $args1 ),
            self::create_input( $args2 )
        );
    }

    /**
     * End the form
     *
     * @return void
     */
    public static function end() {
        printf( '</form>' );
    }

    /**
     * Create wrapped iput field
     *
     * @param  array    $args
     * @return string
     */
    public static function create_input( $args ) {
        $defaults = [
            'name'        => 'input-field',
            'type'        => 'text',
            'label'       => __( 'Input field', 'geomify' ),
            'use_label'   => false,
            'placeholder' => '',
            'class'       => ['geomify-form-input'],
            'attributes'  => [],
            'value'       => '',
            'rows'        => 10,
            'cols'        => 30,
        ];

        $args = wp_parse_args( $args, $defaults );

        $attributes = '';

        foreach ( $args['attributes'] as $key => $value ) {
            $attributes .= sprintf( ' %s="%s" ', $key, $value );
        }

        switch ( $args['type'] ) {
            case 'textarea':
                $element = sprintf( '<textarea name="%s" id="%s" placeholder="%s" rows="%s" cols="%s" class="%s" %s %s>%s</textarea>',
                    $args['name'],
                    $args['name'],
                    $args['placeholder'],
                    $args['rows'],
                    $args['cols'],
                    implode( $args['class'] ),
                    $attributes,
                    $args['required'] ? 'required' : '',
                    $args['value'],
                );
                break;
            case 'color':
                $element = sprintf( '<input type="%s" name="%s" id="%s" value="%s" class="%s" %s/>',
                    $args['type'],
                    $args['name'],
                    $args['name'],
                    geomify_color_value( $args['value'] ),
                    implode( ' ', $args['class'] ),
                    $attributes
                );
                break;
            case 'select':
                $options = ! empty( $args['placeholder'] ) ? '<option value="" selected disabled>' . $args['placeholder'] . '</option>' : '';

                foreach ( $args['options'] as $key => $title ) {
                    $selected = $key == $args['default'] || $key == $args['value'] ? ' selected ' : '';
                    $options .= sprintf( '<option value="%s" %s>%s</option>', $key, $selected, $title );
                }

                $element = sprintf(
                    '<select id="%s" name="%s" %s>%s</select>',
                    $args['name'],
                    $args['name'],
                    $args['required'] ? 'required' : '',
                    $options
                );

                break;
            default:
                $element = sprintf( '<input type="%s" name="%s" id="%s" placeholder="%s" value="%s" class="%s" %s %s/>',
                    $args['type'],
                    $args['name'],
                    $args['name'],
                    $args['placeholder'],
                    $args['value'],
                    implode( ' ', $args['class'] ),
                    $attributes,
                    $args['required'] ? 'required' : '',
                );
                break;
        }

        if ( ! $args['use_label'] ) {
            return sprintf( '<div class="geomify-form-input-wrapper">%s</div>', $element );
        }

        return sprintf( '<div class="geomify-form-input-wrapper"><label for="%s">%s</label>%s</div>',
            $args['name'],
            $args['label'],
            $element
        );
    }


    /**
     * Convert an array to html selectable options
     *
     * @param array $array
     * @param mixed $placeholder
     * @param string $selected
     * @return string
     */
    public static function array2options( $array, $placeholder = null, $selected = '' ) {
        $placeholder = $placeholder === null ? __( 'Choose an option', GTD ) : $placeholder;
        $result      = sprintf( '<option value="" selected disabled>%s</option>', $placeholder );

        foreach ( $array as $item => $prop ) {
            $result .= sprintf( '<option value="%s" %s>%s</option>',
                $item, $item == $selected ? ' selected ' : '', $prop['label'] );
        }

        return $result;
    }

    /**
     * Echo version of array2options()
     *
     * @param array $array
     * @param mixed $placeholder
     * @param string $selected
     * @return void
     */
    public static function __array2options( $array, $placeholder = null, $selected = '' ) {
        printf( self::array2options( $array, $placeholder, $selected ) );
    }

    /**
     * Converts label to placeholder for inputs
     *
     * @param  array  $schema
     * @return void
     */
    public static function convert_label_to_placeholder( $schema ) {
        foreach ( $schema as $key => $prop ) {
            if ( ! isset( $prop['label'] ) ) {
                continue;
            }

            $schema[$key]['placeholder'] = $prop['label'];
            unset( $schema[$key]['label'] );
        }

        return $schema;
    }

    /**
     * Removes properties from schema
     *
     * @param  array   $schema
     * @param  array   $glue
     * @return array
     */
    public static function unset_props( $schema, $glue ) {
        foreach ( $schema as $key => $props ) {

            foreach ( $props as $prop => $value ) {
                if ( in_array( $prop, $glue ) ) {
                    unset( $schema[$key][$prop] );
                }
            }
        }

        return $schema;
    }

    /**
     * Add additional values to schema
     *
     * @param  array   $schema
     * @param  array   $glue
     * @return array
     */
    public static function add_global_props( $schema, $glue ) {
        foreach ( $schema as $key => $props ) {
            foreach ( $glue as $prop => $value ) {
                $schema[$key][$prop] = $value;
            }
        }

        return $schema;
    }

    /**
     * Creates input names from key
     *
     * @param  array   $schema
     * @return array
     */
    public static function add_name_to_inputs( $schema ) {
        $result = [];

        foreach ( $schema as $key => $props ) {
            $result[$key]         = $props;
            $result[$key]['name'] = $key;
        }

        return $result;
    }

}