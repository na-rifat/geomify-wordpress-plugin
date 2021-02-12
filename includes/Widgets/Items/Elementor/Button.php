<?php

namespace geomify\Widgets\Items\Elementor;
use Elementor\Controls_Manager as Controls;
use Elementor\Widget_Base as Base;

class Button extends Base {

    public function get_name() {
        return 'geomify_button';
    }

    public function get_title() {
        return __( 'Button', 'geomify' );
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_categories() {
        return ['geomify'];
    }

    /**
     * Registers controls for
     *
     * @return void
     */
    protected function _register_controls() {

        $this->start_controls_section(
            'settings_section',
            [
                'label' => __( 'Settings', 'geomify' ),
                'tab'   => Controls::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'caption',
            [
                'label'       => __( 'Caption', 'geomify' ),
                'type'        => Controls::TEXT,
                'default'     => __( 'Geomify button', 'geomify' ),
                'input_type'  => 'text',
                'placeholder' => __( 'Caption of the button', 'geomify' ),
            ]
        );

        $this->add_control(
            'url',
            [
                'label'       => __( 'URL to navigate', 'geomify' ),
                'type'        => Controls::URL,
                'input_type'  => 'url',
                'Description' => __( 'Address of the URL to navigate on click action', 'geomify' ),
                'Placeholder' => __( '{site-url}/about-us', 'geomify' ),
                'default'     => [
                    'url'         => '#',
                    'is_external' => false,
                ],
            ]
        );

        $this->add_control(
            'type',
            [
                'label'       => __( 'Style', 'geomify' ),
                'type'        => Controls::SELECT,
                'default'     => 'filled',
                'options'     => [
                    'filled'  => __( 'Filled', 'geomify' ),
                    'borderd' => __( 'Borderd', 'geomify' ),
                ],
                'description' => __( 'Style type of the button', 'geomify' ),
            ]
        );

        $this->add_control(
            'color',
            [
                'label'       => __( 'Caption color', 'geomify' ),
                'type'        => Controls::COLOR,
                'default'     => '#fff',
                'description' => __( 'Caption color to display', 'geomify' ),
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Renders the element to the frontend
     *
     * @return void
     */
    protected function render() {
        $s = $this->get_settings_for_display();
        $c = __( $s['caption'], 'geomifiy' );

        $this->add_inline_editing_attributes( 'caption', 'basic' );
        $this->add_render_attribute(
            'caption',
            [
                'class'  => [$s['type'] == 'filled' ? 'geomify-ew-button g-filled' : 'geomify-ew-button g-borderd'],
                'target' => $s['url']['is_external'] == 'on' ? '_blank' : '_self',
            ]
        );
        $attr = $this->get_render_attribute_string( 'caption' );

        $this->add_inline_editing_attributes( 'color', 'basic' );
        $this->add_render_attribute(
            'color',
            [
                'style' => "color: {$s['color']}",
            ]
        );
        $color = $this->get_render_attribute_string( 'color' );

        echo "<a href='{$s['url']['url']}' {$attr} {$color}>{$c}</a>";
    }

    protected function _content_template() {

    }

    public function get_style_depends() {
        return ['geomify-widgets-script'];
    }
}