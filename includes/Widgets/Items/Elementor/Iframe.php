<?php

namespace geomify\Widgets\Items\Elementor;

defined( 'ABSPATH' ) or exit;

use \Elementor\Controls_Manager as Controls;
use \Elementor\Widget_Base as Base;

class Iframe extends Base {
    public function get_name() {
        return 'geomify_iframe';
    }

    public function get_title() {
        return __( 'Iframe', GEOMIFY_TEXT_DOMAIN );
    }

    public function get_categories() {
        return ['geomify'];
    }

    public function get_keywords() {
        return ['geomify', 'geomify iframe', 'iframe', 'browser'];
    }

    public function get_script_depends() {
        return ['geomify-widget-scripts'];
    }

    public function get_style_depends() {
        return ['geomify-widget-styles'];
    }

    protected function _register_controls() {
        $domain = GEOMIFY_TEXT_DOMAIN;

        // General
        $this->start_controls_section(
            'general_settings',
            [
                'label' => __( '$text', $domain ),
                'tab'   => Controls::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'browser_id',
            [
                'label'   => __( 'Browser ID', $domain ),
                'type'    => Controls::TEXT,
                'default' => 'dashboard_browser',
            ]
        );

        $this->add_control(
            'startup_url',
            [
                'label'       => __( 'Startup URL', $domain ),
                'type'        => Controls::TEXT,
                'placeholder' => __( 'URL to navigate on first load', $domain ),
            ]
        );
        $this->end_controls_section();
        // General end

        // Style section
        $this->start_controls_section(
            'style',
            [
                'label' => __( 'Styles', $domain ),
                'tab'   => Controls::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label'           => __( 'Height', $domain ),
                'type'            => Controls::SLIDER,
                'devices'         => [
                    'mobile',
                    'tablet',
                    'desktop',
                ],
                'size_units'      => [
                    'px',
                    '%',
                    'vh',
                ],
                'range'           => [
                    'px' => [
                        'min' => 0,
                        'max' => 1200,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'mobile_default'  => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'tablet_default'  => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'desktop_default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors'       => [
                    '{{WRAPPER}} *, .elementor-widget-geomify_iframe' => 'height: {{SIZE}}{{UNIT}}!important;',
                ],

            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label'           => __( 'Width', $domain ),
                'type'            => Controls::SLIDER,
                'devices'         => [
                    'mobile',
                    'tablet',
                    'desktop',
                ],
                'size_units'      => [
                    'px',
                    '%',
                    'vw',
                ],
                'range'           => [
                    'px' => [
                        'min' => 0,
                        'max' => 1200,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'mobile_default'  => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'tablet_default'  => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'desktop_default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors'       => [
                    '{{WRAPPER}} iframe' => 'width: {{SIZE}}{{UNIT}};',
                ],

            ]
        );

        $this->end_controls_section();
        // Style section end
    }

    protected function render() {
        $s = $this->get_settings_for_display();

        printf( '<iframe id="%s" class="geomify-iframe" src="%s"></iframe>', $s['browser_id'], $s['startup_url'] );

    }
}