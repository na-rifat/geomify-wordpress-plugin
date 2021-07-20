<?php

namespace geomify\Widgets\Items\Elementor;

defined( 'ABSPATH' ) or exit;

use Elementor\Controls_Manager as Controls;
use Elementor\Widget_Base as Base;

class Multiform extends Base {
    public function get_name() {
        return 'geomify_multiform';
    }

    public function get_title() {
        return __( 'Multi form', 'geomify' );
    }

    public function get_categories() {
        return ['geomify'];
    }

    public function get_keywords() {
        return ['geomify', 'geomify form', 'multi form', 'geomify multi form'];
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_script_depends() {
        return ['geomify-widgets-script'];
    }

    public function _register_controls() {
        $domain       = 'geomify';
        $sbn_selector = '{{WRAPPER}} .geomify-ms-bottombar-item .geomify-ms-button:nth-child(2) > div';
        $sbp_selector = '{{WRAPPER}} .geomify-ms-bottombar-item .geomify-ms-button:nth-child(1) > div';

        // General
        $this->start_controls_section(
            'general_settings',
            [
                'label' => __( 'General', $domain ),
                'tab'   => Controls::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'form_title',
            [
                'label'   => __( 'Title', $domain ),
                'type'    => Controls::TEXT,
                'default' => __( 'Multi step form', $domain ),
            ]
        );

        $this->add_control(
            'form_name',
            [
                'label'   => __( 'Form name', $domain ),
                'type'    => Controls::TEXT,
                'default' => 'my_form',
            ]
        );

        $this->add_responsive_control(
            'form_height',
            [
                'label'           => __( 'Height', $domain ),
                'type'            => Controls::SLIDER,
                'size_units'      => ['px', 'vh', '%'],
                'devices'         => ['mobile', 'tablet', 'desktop'],
                'range'           => [
                    'px' => [
                        'min' => 0,
                        'max' => 800,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'mobile_default'  => [
                    'unit' => 'px',
                    'size' => 600,
                ],
                'tablet_default'  => [
                    'unit' => 'px',
                    'size' => 600,
                ],
                'desktop_default' => [
                    'unit' => 'px',
                    'size' => 600,
                ],
                'selectors'       => [
                    '{{WRAPPER}} .geomify-ms-form-wrapper' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'min_width',
            [
                'label'           => __( 'Minimum width' ),
                'type'            => Controls::SLIDER,
                'size_units'      => ['px', 'vw', '%'],
                'range'           => [
                    'px' => [
                        'min' => 0,
                        'max' => 1400,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'devices'         => ['mobile', 'tablet', 'desktop'],
                'mobile_default'  => [
                    'unit' => 'px',
                    'size' => 600,
                ],
                'tablet_default'  => [
                    'unit' => 'px',
                    'size' => 800,
                ],
                'desktop_default' => [
                    'unit' => 'px',
                    'size' => 800,
                ],
                'selectors'       => [
                    '{{WRAPPER}}, {{WRAPPER}} .geomify-ms-form-wrapper' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'max_width',
            [
                'label'           => __( 'Minimum width' ),
                'type'            => Controls::SLIDER,
                'size_units'      => ['px', 'vw', '%'],
                'range'           => [
                    'px' => [
                        'min' => 0,
                        'max' => 1400,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'devices'         => ['mobile', 'tablet', 'desktop'],
                'mobile_default'  => [
                    'unit' => 'px',
                    'size' => 600,
                ],
                'tablet_default'  => [
                    'unit' => 'px',
                    'size' => 800,
                ],
                'desktop_default' => [
                    'unit' => 'px',
                    'size' => 800,
                ],
                'selectors'       => [
                    '{{WRAPPER}}, {{WRAPPER}} .geomify-ms-form-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'shortcode',
            [
                'label'       => __( 'Form shortcode', $domain ),
                'type'        => Controls::TEXT,
                'placeholder' => '[geomify-ms-form slug=abcd]',
            ]
        );

        $this->add_control(
            'success_shortcode',
            [
                'label'       => __( 'Success shortcode', $domain ),
                'type'        => Controls::TEXT,
                'placeholder' => '[geomify-ms-form slug=abcd]',
            ]
        );

        $this->end_controls_section();
        // General end

        // Form style section
        $this->start_controls_section(
            'styles',
            [
                'label' => __( 'Styles', $domain ),
                'tab'   => Controls::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'padding',
            [
                'label'           => __( 'Padding', $domain ),
                'type'            => Controls::DIMENSIONS,
                'units'           => ['px', '%', 'rem'],
                'devices'         => ['mobile', 'tablet', 'desktop'],
                'mobile_default'  => [
                    'unit'   => 'px',
                    'top'    => 30,
                    'right'  => 30,
                    'bottom' => 30,
                    'left'   => 30,
                ],
                'tablet_default'  => [
                    'unit'   => 'px',
                    'top'    => 30,
                    'right'  => 30,
                    'bottom' => 30,
                    'left'   => 30,
                ],
                'desktop_default' => [
                    'unit'   => 'px',
                    'top'    => 30,
                    'right'  => 30,
                    'bottom' => 30,
                    'left'   => 30,
                ],
                'selectors'       => [
                    '{{WRAPPER}} .geomify-ms-form-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'margin',
            [
                'label'           => __( 'Margin', $domain ),
                'type'            => Controls::DIMENSIONS,
                'units'           => ['px', 'rem'],
                'devices'         => ['mobile', 'tablet', 'desktop'],
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
                    '{{WRAPPER}} .geomify-ms-form-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{VALUE}} {{BOTTOM}}{{VALUE}} {{LEFT}}{{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'border',
                'label'    => __( 'Border', $domain ),
                'selector' => '{{WRAPPER}} .geomify-ms-form-wrapper',
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label'     => __( 'Background color', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#164E86',
                'selectors' => [
                    '{{WRAPPER}} .geomify-ms-form-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'bottom_gap',
            [
                'label'           => __( 'Bottom gap', $domain ),
                'type'            => Controls::SLIDER,
                'devices'         => ['mobile', 'tablet', 'desktop'],
                'units'           => ['px', 'vh', '%', 'rem'],
                'range'           => [
                    'px'  => [
                        'min' => 0,
                        'max' => 500,
                    ],
                    'vh'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%'   => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'mobile_default'  => [
                    'unit' => 'px',
                    'size' => 150,
                ],
                'tablet_default'  => [
                    'unit' => 'px',
                    'size' => 150,
                ],
                'desktop_default' => [
                    'unit' => 'px',
                    'size' => 150,
                ],
                'selectors'       => [
                    '{{WRAPPER}} .geomify-ms-bottombar' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        // Form style section end

        // Step buttons next
        $this->start_controls_section(
            'step_buttons_next',
            [
                'label' => __( 'Step buttons next', $domain ),
                'tab'   => Controls::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'sbn_styles' );

        $this->start_controls_tab(
            'sbn_normal_styles',
            [
                'label' => __( 'Normal', $domain ),
            ]
        );

        $this->add_control(
            'sbn_background_color',
            [
                'label'     => __( 'Background color', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#51a7f900',
                'selectors' => [
                    $sbn_selector => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'sbn_color',
            [
                'label'     => __( 'Color', $domain ),
                'type'      => Controls::COLOR,
                'defualt'   => '#ffffff',
                'selectors' => [
                    $sbn_selector => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'sbn_hover_styles',
            [
                'label' => __( 'Hover', $domain ),
            ]
        );

        $this->add_control(
            'sbn_background_color_hover',
            [
                'label'     => __( 'Background color', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#51a7f9',
                'selectors' => [
                    $sbn_selector . ':hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'sbn_color_hover',
            [
                'label'     => __( 'Color', $domain ),
                'type'      => Controls::COLOR,
                'defualt'   => '#ffffff',
                'selectors' => [
                    $sbn_selector . ':hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => __( 'sbn_border', $domain ),
                'label'    => __( 'Border', $domain ),
                'selector' => $sbn_selector,
            ]
        );

        $this->end_controls_section();
        // Step buttons next and

        // Step buttons previous
        $this->start_controls_section(
            'step_buttons_previous',
            [
                'label' => __( 'Step buttons previous', $domain ),
                'tab'   => Controls::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'sbp_styles' );

        $this->start_controls_tab(
            'sbp_normal_styles',
            [
                'label' => __( 'Normal', $domain ),
            ]
        );

        $this->add_control(
            'sbp_background_color',
            [
                'label'     => __( 'Background color', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#51a7f9',
                'selectors' => [
                    $sbp_selector => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'sbp_color',
            [
                'label'     => __( 'Color', $domain ),
                'type'      => Controls::COLOR,
                'defualt'   => '#ffffff',
                'selectors' => [
                    $sbp_selector => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'sbp_hover_styles',
            [
                'label' => __( 'Hover', $domain ),
            ]
        );

        $this->add_control(
            'sbp_background_color_hover',
            [
                'label'     => __( 'Background color', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#51a7f900',
                'selectors' => [
                    $sbp_selector . ':hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'sbp_color_hover',
            [
                'label'     => __( 'Color', $domain ),
                'type'      => Controls::COLOR,
                'defualt'   => '#ffffff',
                'selectors' => [
                    $sbp_selector . ':hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => __( 'sbp_border', $domain ),
                'label'    => __( 'Border', $domain ),
                'selector' => $sbn_selector,
            ]
        );

        $this->end_controls_section();
        // Step buttons previous and

        // Labels style
        $this->start_controls_section(
            'labels_style',
            [
                'label' => __( 'Labels', $domain ),
                'tab'   => Controls::TAB_STYLE,
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label'     => __( 'Color', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} form label' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'label_typography',
                'label'    => __( 'Typography', $domain ),
                'selector' => '{{WRAPPER}} form label',
            ]
        );

        $this->end_controls_section();
        // Labels style end

        // Placeholder styles

        $this->start_controls_section(
            'placeholder_styles', [
                'label' => __( 'Placeholder styles', $domain ),
                'tab'   => Controls::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'placeholder_typography',
                'label'    => __( 'Typography', $domain ),
                'selector' => '{{WRAPPER}} input::placeholder, {{WRAPPER}} textarea::placeholder',
            ]
        );

        $this->add_control(
            'placeholder_color', [
                'label'     => __( 'Color', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#969696',
                'selectors' => [
                    '{{WRAPPER}} input::placeholder, {{WRAPPER}} textarea::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        // Placeholder styles ended
    }

    public function render() {
        $s = $this->get_settings_for_display();

        echo sprintf(
            '<div class="geomify-ms-form-wrapper" data-success_shortcode="%s" >%s</div>',
            str_replace( '"', '', $s['success_shortcode'] ),
            do_shortcode( $s['shortcode'] )
        );
    }
}