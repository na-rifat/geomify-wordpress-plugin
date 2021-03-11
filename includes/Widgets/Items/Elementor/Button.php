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

    public function get_keywords() {
        return ['geomify', 'button', 'geomify button'];
    }

    /**
     * Registers controls for
     *
     * @return void
     */
    protected function _register_controls() {

        $this->start_controls_section(
            'contents section',
            [
                'label' => __( 'Settings', 'geomify' ),
                'tab'   => Controls::TAB_CONTENT,
            ]
        );

        // Caption
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

        // Url
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

        $this->end_controls_section();

        $this->start_controls_section(
            'style_settings',
            [
                'label' => __( 'Styles', 'geomify' ),
                'tab'   => Controls::TAB_CONTENT,
            ]
        );

        // $this->add_control(
        //     'fill_style',
        //     [
        //         'label'       => __( 'Fill style', 'geomify' ),
        //         'type'        => Controls::SELECT,
        //         'default'     => 'filled',
        //         'options'     => [
        //             'filled'  => __( 'Filled', 'geomify' ),
        //             'borderd' => __( 'Borderd', 'geomify' ),
        //         ],
        //         'description' => __( 'Style type of the button', 'geomify' ),
        //     ]
        // );

        // Text color
        $this->add_control(
            'text_color',
            [
                'label'     => __( 'Text color', 'geomify' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#fff',
                'selectors' => [
                    '{{WRAPPER}} a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'texthover_color',
            [
                'label'     => __( 'Text hover color', 'geomify' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#000',
                'selectors' => [
                    '{{WRAPPER}} a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Background color

        $this->add_control(
            'background_color',
            [
                'label'     => __( 'Background color', 'geomify' ),
                'type'      => Controls::COLOR,
                'default'   => '#00FFFF',
                'selectors' => [
                    '{{WRAPPER}} a' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'background_hover_color',
            [
                'label'     => __( 'Background hover color', 'geomify' ),
                'type'      => Controls::COLOR,
                'default'   => '#00FFFF',
                'selectors' => [
                    '{{WRAPPER}} a:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        // Size section
        $this->add_responsive_control(
            'width',
            [
                'label'           => __( 'Width', 'geomify' ),
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
            'vertical_padding',
            [
                'label'           => __( 'Vertical padding', 'geomify' ),
                'type'            => Controls::SLIDER,
                'devices'         => ['mobile', 'tablet', 'desktop'],
                'unit'            => ['px', 'em'],
                'range'           => [
                    'px' => [
                        'min' => 0,
                        'max' => 400,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'mobile_default'  => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'tablet_default'  => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'desktop_default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors'       => [
                    '{{WRAPPER}} a' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'horizontal_padding',
            [
                'label'           => __( 'Horizontal padding', 'geomify' ),
                'type'            => Controls::SLIDER,
                'devices'         => ['mobile', 'tablet', 'desktop'],
                'unit'            => ['px', 'em'],
                'range'           => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'mobile_default'  => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'tablet_default'  => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'desktop_default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'selectors'       => [
                    '{{WRAPPER}} a' => 'padding-right: {{SIZE}}{{UNIT}}; padding-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label'          => __( 'Border radius', 'geomify' ),
                'type'           => Controls::SLIDER,
                'units'          => ['px', 'em', '%'],
                'devices'        => ['mobile', 'tablet', 'desktop'],
                'range'          => [
                    'px' => [
                        'min' => 0,
                        'max' => 30,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => 3,
                ],
                'selectors'      => [
                    '{{WRAPPER}} a' => 'border-radius: {{SIZE}}{{UNIT}};',
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

        $this->add_inline_editing_attributes( 'caption' );

        $this->add_render_attribute(
            'caption',
            [
                'class'  => 'geomify-button',
                'href'   => $s['url']['url'],
                'target' => $s['url']['is_external'] == 'on' ? '_blank' : '_self',
            ]
        );

        $attr = $this->get_render_attribute_string( 'caption' );

        $element = sprintf( '<a %s >%s</a>',
            $attr,
            $s['caption'] );

        echo $element;

        // $this->add_inline_editing_attributes( 'color', 'basic' );
        // $this->add_render_attribute(
        //     'color',
        //     [
        //         'style' => "color: {$s['color']}",
        //     ]
        // );
        // $color = $this->get_render_attribute_string( 'color' );

        // echo "<a href='{$s['url']['url']}' {$attr}>{$c}</a>";
    }

    protected function _content_template() {

    }

    public function get_style_depends() {
        return ['geomify-widgets-script'];
    }
}