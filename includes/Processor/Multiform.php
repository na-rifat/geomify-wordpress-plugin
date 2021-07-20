<?php

namespace geomify\Processor;

defined( 'ABSPATH' ) or exit;

class Multiform {
    function __construct() {
        $this->element               = '<div class="geomify-ms-form">';
        $this->steps                 = 0;
        $this->input_count           = 0;
        $this->globals               = [];
        $this->required_fields_title = 'All field are required';
    }

    /**
     * Creates top slidbar
     *
     * @return void
     */
    public function create_topbar() {
        $element = '<div class="geomify-ms-topbar">';

        for ( $i = 0; $i < $this->steps; $i++ ) {
            $element .= '<div class="geomify-ms-topbar-item"></div>';
        }

        return sprintf( '%s</div>', $element );
    }

    /**
     * Bottom bar
     *
     * @return void
     */
    public function create_bottombar() {
        $element = '<div class="geomify-ms-bottombar">';

        $item = '<div class="geomify-ms-bottombar-item">
        <div class="geomify-ms-button">%s</div>
        <div class="geomify-ms-button">%s</div>
        </div>';

        for ( $i = 0; $i < $this->steps; $i++ ) {
            if ( $this->steps == 1 ) {
                $element .= sprintf( $item, '', '<div>Submit</div>' );
                break;
            }

            switch ( $i ) {
                case 0:
                    $element .= sprintf( $item, '', '<div>Next</div>' );
                    break;
                case $this->steps - 1:
                    $element .= sprintf( $item, '<div>Previous</div>', '<div>Submit</div>' );
                    break;
                default:
                    $element .= sprintf( $item, '<div>Previous</div>', '<div>Next</div>' );
                    break;
            }
        }

        return sprintf( '%s</div>', $element );
    }

    /**
     * Start a new step
     *
     * @return void
     */
    public function start_step() {
        $this->element .= '<div class="geomify-ms-step">';
    }

    /**
     * End created step
     *
     * @return void
     */
    public function end_step() {
        $this->element .= '</div>';
        $this->steps++;
    }

    /**
     * Create row of field
     *
     * @param  array  $args
     * @return void
     */
    public function create_field( $args ) {
        $this->element .= sprintf(
            '<div class="geomify-ms-input-group">%s</div>',
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
            '<div class="geomify-ms-input-group pair-group">%s%s</div>',
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
        $org_args = $args;
        $defaults = [
            'name'        => sprintf( 'input-field-%s', $this->input_count ),
            'type'        => 'text',
            'label'       => __( 'Input field', 'geomify' ),
            'use_label'   => false,
            'placeholder' => '',
            'class'       => ['geomify-ms-input'],
            'attributes'  => [],
            'value'       => '',
            'rows'        => 10,
            'cols'        => 30,
            'required'    => false,
        ];

        $args = wp_parse_args( $args, $defaults );

        foreach ( $args as $prop => $value ) {
            if ( isset( $org_args[$prop] ) ) {
                continue;
            }

            if ( isset( $this->globals[$prop] ) ) {
                $args[$prop] = $this->globals[$prop];
            }
        }

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
                    $args['value']
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
                    $selected = $key == $args['default'] ? ' selected ' : '';
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

        $this->input++;

        if ( ! $args['use_label'] ) {
            return sprintf( '<div class="geomify-ms-input-wrapper">%s</div>', $element );
        }

        return sprintf( '<div class="geomify-ms-input-wrapper"><label for="%s">%s</label>%s</div>',
            $args['name'],
            $args['label'],
            $element
        );
    }

    /**
     * Return number of step(s)
     *
     * @return int
     */
    public function step_count() {
        return $this->steps;
    }

    /**
     * Return number of input element(s)
     *
     * @return int
     */
    public function input_count() {
        return $this->input_count;
    }

    /**
     * Get formatted form string
     *
     * @return string
     */
    public function get() {
        $inputs = sprintf(
            '<form action="#" method="POST" data-name="%s" >%s</div>%s</form>',
            $this->name,
            $this->element,
            sprintf( '<input type="hidden" name="nonce" value="%s" data-action="%s" >', wp_create_nonce( $this->name . '_submit' ), $this->name . '_submit' )
        );
        // $inputs    = sprintf( '%s</div>', $this->element );
        $topbar    = '';
        $bottombar = '';

        if ( $this->steps >= 1 ) {
            $topbar = $this->create_topbar();
        }

        $bottombar = $this->create_bottombar();

        $required_title = sprintf( '<div class="geomify-ms-required-title">%s
        <script>
            multiStepForm();
        </script></div>', $this->required_fields_title );

        $form = $topbar . $required_title . $inputs . $bottombar;

        return $form;
    }
}