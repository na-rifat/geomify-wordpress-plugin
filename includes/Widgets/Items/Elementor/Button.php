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
                'label'     => __( 'Color', 'geomify' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#fff',
                'selectors' => [
                    '{{WRAPPER}} a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hover_color',
            [
                'label'     => __( 'Hover color', 'geomify' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#000',
                'selectors' => [
                    '{{WRAPPER}} a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label'           => __( 'Slider', 'geomify' ),
                'type'            => Controls::SLIDER,
                'size_units'      => ['px', 'rem', 'em', '%'],
                'range'           => [
                    'px'  => [
                        'min' => 0,
                        'max' => 400,
                    ],
                    '%'   => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em'  => [
                        'min' => 0,
                        'max' => 5,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 5,
                    ],
                ],
                'devices'         => ['desktop', 'tablet', 'mobile'],
                'desktop_default' => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'tablet_default'  => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'mobile_default'  => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors'       => [
                    '{{WRAPPER}} a' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label'           => __( 'Alignment', 'geomify' ),
                'type'            => Controls::CHOOSE,
                'devices'         => ['desktop', 'tablet', 'mobile'],
                'options'         => [
                    'left'   => [
                        'title' => __( 'Left', 'geomify' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'geomify' ),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right'  => [
                        'title' => __( 'Right', 'geomify' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'desktop_default' => 'left',
                'tablet_default'  => 'left',
                'mobile_default'  => 'center',
                'selectors'       => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}}',
                ],
            ],

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
                'class'  => [$s['type'] == 'filled' ? "geomify-ew-button g-filled" : "geomify-ew-button g-borderd"],
                'target' => $s['url']['is_external'] == 'on' ? '_blank' : '_self',
            ]
        );
        $attr = $this->get_render_attribute_string( 'caption' );

        // $this->add_inline_editing_attributes( 'color', 'basic' );
        // $this->add_render_attribute(
        //     'color',
        //     [
        //         'style' => "color: {$s['color']}",
        //     ]
        // );
        // $color = $this->get_render_attribute_string( 'color' );

        echo "<a href='{$s['url']['url']}' {$attr}>{$c}</a>";
    }

    protected function _content_template() {

    }

    public function get_style_depends() {
        return ['geomify-widgets-script'];
    }
}