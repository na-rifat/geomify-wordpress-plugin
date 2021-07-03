<?php

namespace geomify\Widgets\Items\Elementor;

defined( 'ABSPATH' ) or exit;

use Elementor\Controls_Manager as Controls;
use Elementor\Repeater as Repeater;
use Elementor\Widget_Base as Base;

class Compare_table extends Base {

    public function get_name() {
        return 'geomify_compare_table';
    }

    public function get_title() {
        return __( 'Compare table', 'geomify' );
    }

    public function get_icon() {
        return 'eicon-table';
    }

    public function get_categories() {
        return ['geomify'];
    }

    public function get_keywords() {
        return ['table', 'compare', 'compare table', 'geomify'];
    }

    protected function _register_controls() {
        $domain = 'geomify';

        $this->start_controls_section(
            'general_section',
            [
                'label' => __( 'General', $domain ),
                'tab'   => Controls::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'packages_title',
            [
                'label'       => __( 'Packages title', $domain ),
                'description' => __( 'Title for the top row of packages', $domain ),
                'type'        => Controls::TEXT,
                'default'     => __( 'Compare plans', $domain ),
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label'     => __( 'Background', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .geomify-compare-table-wrapper' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'border',
                'label'    => __( 'Border', $domain ),
                'selector' => '{{WRAPPER}} .geomify-compare-table-wrapper',
            ]
        );

        $this->add_control(
            'cell_border_color',
            [
                'label'     => __( 'Cell border color', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} td, {{WRAPPER}} th, {{WRAPPER}} table' => "border-color: {{VALUE}}",
                ],
            ]
        );

        $this->add_responsive_control(
            'cell_padding',
            [
                'label'           => __( 'Cell padding', $domain ),
                'type'            => Controls::SLIDER,
                'units'           => ['px', '%'],
                'range'           => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'devices'         => ['mobile', 'tablet', 'desktop'],
                'mobile_default'  => [
                    'unit' => 'px',
                    'size' => 6,
                ],
                'tablet_default'  => [
                    'unit' => 'px',
                    'size' => 6,
                ],
                'desktop_default' => [
                    'unit' => 'px',
                    'size' => 6,
                ],
                'selectors'       => [
                    '{{WRAPPER}} td, {{WRAPPER}} th' => 'padding: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label'           => __( 'Padding', $domain ),
                'type'            => Controls::DIMENSIONS,
                'size_units'      => ['px', '%'],
                'devices'         => ['mobile', 'tablet', 'desktop'],
                'range'           => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                    '%'  => [
                        'min'  => 0,
                        'maxx' => 100,
                    ],
                ],
                'mobile_default'  => [
                    'unit'   => 'px',
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                ],
                'tablet_default'  => [
                    'unit'   => 'px',
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                ],
                'desktop_default' => [
                    'unit'   => 'px',
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                ],
                'selectors'       => [
                    '{{WRAPPER}} .geomify-compare-table-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'margin',
            [
                'label'           => __( 'Padding', $domain ),
                'type'            => Controls::DIMENSIONS,
                'size_units'      => ['px', '%'],
                'devices'         => ['mobile', 'tablet', 'desktop'],
                'range'           => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                    '%'  => [
                        'min'  => 0,
                        'maxx' => 100,
                    ],
                ],
                'mobile_default'  => [
                    'unit'   => 'px',
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                ],
                'tablet_default'  => [
                    'unit'   => 'px',
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                ],
                'desktop_default' => [
                    'unit'   => 'px',
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                ],
                'selectors'       => [
                    '{{WRAPPER}} .geomify-compare-table-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'enabled_color',
            [
                'label'     => __( 'Enabled color', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#17bd1a',
                'selectors' => [
                    '{{WRAPPER}} td i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'disabled_color',
            [
                'label'     => __( 'Disabled color', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .ico-na' => 'color: {{VALUE}};',
                ],
            ]
        );

        // List controls
        $repeater = new Repeater();

        $repeater->add_control(
            'feature_title', [
                'label'       => __( 'Package title', $domain ),
                'type'        => Controls::TEXT,
                'default'     => __( 'Package', $domain ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'package_free',
            [
                'label'   => __( 'Enabled', $domain ),
                'type'    => Controls::CHOOSE,
                'options' => [
                    'disabled' => [
                        'title' => __( 'Disabled', $domain ),
                        'icon'  => 'eicon-ban',
                    ],
                    'enabled'  => [
                        'title' => __( 'Enabled', $domain ),
                        'icon'  => 'eicon-check',
                    ],
                ],
                'default' => 'enabled',
            ]
        );

        $repeater->add_control(
            'package_basic',
            [
                'label'   => __( 'Enabled', $domain ),
                'type'    => Controls::CHOOSE,
                'options' => [
                    'disabled' => [
                        'title' => __( 'Disabled', $domain ),
                        'icon'  => 'eicon-ban',
                    ],
                    'enabled'  => [
                        'title' => __( 'Enabled', $domain ),
                        'icon'  => 'eicon-check',
                    ],
                ],
                'default' => 'enabled',
            ]
        );

        $repeater->add_control(
            'package_facilitator',
            [
                'label'   => __( 'Enabled', $domain ),
                'type'    => Controls::CHOOSE,
                'options' => [
                    'disabled' => [
                        'title' => __( 'Disabled', $domain ),
                        'icon'  => 'eicon-ban',
                    ],
                    'enabled'  => [
                        'title' => __( 'Enabled', $domain ),
                        'icon'  => 'eicon-check',
                    ],
                ],
                'default' => 'enabled',
            ]
        );

        $repeater->add_control(
            'package_creator',
            [
                'label'   => __( 'Enabled', $domain ),
                'type'    => Controls::CHOOSE,
                'options' => [
                    'disabled' => [
                        'title' => __( 'Disabled', $domain ),
                        'icon'  => 'eicon-ban',
                    ],
                    'enabled'  => [
                        'title' => __( 'Enabled', $domain ),
                        'icon'  => 'eicon-check',
                    ],
                ],
                'default' => 'enabled',
            ]
        );

        $repeater->add_control(
            'package_enterprise',
            [
                'label'   => __( 'Enabled', $domain ),
                'type'    => Controls::CHOOSE,
                'options' => [
                    'disabled' => [
                        'title' => __( 'Disabled', $domain ),
                        'icon'  => 'eicon-ban',
                    ],
                    'enabled'  => [
                        'title' => __( 'Enabled', $domain ),
                        'icon'  => 'eicon-check',
                    ],
                ],
                'default' => 'enabled',
            ]
        );

        $this->add_control(
            'packages',
            [
                'label'       => __( 'Feature list', $domain ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'feature_title'       => __( 'Feature 1', $domain ),
                        'package_free'        => 'disabled',
                        'package_basic'       => 'disabled',
                        'package_facilitator' => 'disabled',
                        'package_creator'     => 'disabled',
                        'package_enterprise'  => 'disabled', 
                    ],
                ],
                'title_field' => '{{{ feature_title }}}',
            ]
        );

        $this->end_controls_section();

        // Feature title styles
        $this->start_controls_section(
            'feature_title_styles',
            [
                'label' => __( 'Feature title styles', $domain ),
                'tab'   => Controls::TAB_CONTENT,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'feature_title_typography',
                'label'    => __( 'Typography', $domain ),
                'selector' => '{{WRAPPER}} thead th:first-child',
            ]
        );

        $this->add_control(
            'feature_title_color',
            [
                'label'   => __( 'Color', $domain ),
                'type'    => Controls::COLOR,
                'default' => 'black',
            ]
        );

        $this->end_controls_section();

        // Package column header styles
        $this->start_controls_section(
            'package_header_styles',
            [
                'label' => __( 'Package header styles', $domain ),
                'tab'   => Controls::TAB_CONTENT,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'package_header_typography',
                'label'    => __( 'Typography', $domain ),
                'selector' => '{{WRAPPER}} thead tr > *:not(:first-child)',
            ]
        );

        $this->add_control(
            'package_header_color',
            [
                'label'     => __( 'Color', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} thead tr > *:not(:first-child)' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
        // Package header style

        // Package name style
        $this->start_controls_section(
            'package_name_styles', [
                'label' => __( 'Package name styles', $domain ),
                'tab'   => Controls::TAB_CONTENT,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'package_name_typography',
                'label'    => __( 'Typography', $domain ),
                'selector' => '{{WRAPPER}} tbody tr td:first-child',
            ]
        );

        $this->add_control(
            'package_name_color',
            [
                'label'     => __( 'Color', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} tbody tr td:first-child' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $s      = $this->get_settings_for_display();
        $domain = 'geomify';

        ob_start();
        include __DIR__ . '/views/Compare_table_list.php';
        echo ob_get_clean();
    }

}
