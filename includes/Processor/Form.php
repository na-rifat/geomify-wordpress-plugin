<?php

namespace geomify\Processor;

defined( 'ABSPATH' ) or exit;

class Form {
    function __construct() {
        $this->element     = '<div class="geomify-form">';
        $this->input_count = 0;

    }

    /**
     * Create row of field
     *
     * @param  array  $args
     * @return void
     */
    public function create_field( $args ) {
        $this->element .= sprintf(
            '<div class="geomify-form-input-group">%s</div>',
            $this->create_input( $args )
        );
    }

    /**
     * Creates row of fields pair
     *
     * @param  array  $args1
     * @param  array  $args2
     * @return void
     */
    public function create_field_pair( $args1, $args2 ) {
        $this->element .= sprintf(
            '<div class="geomify-form-input-group pair-group">%s%s</div>',
            $this->create_input( $args1 ),
            $this->create_input( $args2 )
        );
    }

    /**
     * Create wrapped iput field
     *
     * @param  array    $args
     * @return string
     */
    public function create_input( $args ) {
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
     * Get formatted form string
     *
     * @return string
     */
    public function get() {
        return sprintf( '<form action="#" method="POST">%s</div></form>', $this->element );
    }

    public function _get() {
        echo $this->get();
    }
}