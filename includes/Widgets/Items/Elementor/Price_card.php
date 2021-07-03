<?php

namespace geomify\Widgets\Items\Elementor;

defined( 'ABSPATH' ) or exit;

use Elementor\Controls_Manager as Controls;
use Elementor\Widget_Base as Base;

class Price_card extends Base {
    public function get_name() {
        return 'geomify_price_card';
    }

    public function get_title() {
        return __( 'Price card', 'geomify' );
    }

    public function get_categories() {
        return ['geomify'];
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    public function get_keywords() {
        return ['package table', 'price table', 'pricing plan', 'package card', 'price card'];
    }

    protected function _register_controls() {
        $domain = 'geomify';

        // General settings
        $this->start_controls_section(
            'general_settings',
            [
                'label' => __( 'General', $domain ),
                'tab'   => Controls::TAB_CONTENT,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'     => 'background_fill',
                'label'    => __( 'Background fill', $domain ),
                'types'    => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .geomify-price-card',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'border',
                'label'    => __( 'Border', $domain ),
                'selector' => '{{WRAPPER}} .geomify-price-card',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'box_shadow',
                'label'    => __( 'Box shadow', $domain ),
                'selector' => '{{WRAPPER}} .geomify-price-card',
            ]
        );

        $this->add_control(
            'text_alignment',
            [
                'label'     => __( 'Text alignment', $domain ),
                'type'      => Controls::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __( 'Left', $domain ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', $domain ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => __( 'Right', $domain ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .geomify-price-card' => 'text-align: {{VALUE}};',
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
                        'unit' => 'px',
                        'min'  => 0,
                        'max'  => 200,
                    ],
                    '%'  => [
                        'unit' => '%',
                        'min'  => 0,
                        'max'  => 100,
                    ],
                ],
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
                    '{{WRAPPER}} .geomify-price-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        // General settings end

        // Styles

        // Stlye

        // Image
        $this->start_controls_section(
            'image_section',
            [
                'label' => __( 'Package logo', $domain ),
                'tab'   => Controls::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'package_image',
            [
                'label'   => __( 'Image', $domain ),
                'type'    => Controls::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'image_alignment',
            [
                'label'     => __( 'Alignment', $domain ),
                'type'      => Controls::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __( 'Left', $domain ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', $domain ),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right'  => [
                        'title' => __( 'Right', $domain ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .package-image' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
        // Image end

        // Title
        $this->start_controls_section(
            'title_section',
            [
                'label' => __( 'Title', $domain ),
                'tab'   => Controls::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label'   => __( 'Title', $domain ),
                'type'    => Controls::TEXT,
                'default' => __( 'Package', $domain ),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => __( 'Typography', $domain ),
                'selector' => '{{WRAPPER}} .package-title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __( 'Color', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .package-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
        // Title end

        // Subtitle
        $this->start_controls_section(
            'subtitle_section',
            [
                'label' => __( 'Subtitle', $domain ),
                'tab'   => Controls::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label'   => __( 'Subtitle', $domain ),
                'type'    => Controls::TEXT,
                'default' => __( 'Subtitle', $domain ),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'subtitle_typography',
                'label'    => __( 'Typography', $domain ),
                'selector' => '{{WRAPPER}} .package-subtitle',
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label'     => __( 'Subtitle color', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .package-subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
        // Subtitle end

        // Description
        $this->start_controls_section(
            'description_section',
            [
                'label' => __( 'Description', $domain ),
                'tab'   => Controls::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'description',
            [
                'label'   => __( 'Description', $domain ),
                'type'    => Controls::TEXTAREA,
                'default' => __( 'Package description', $domain ),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'label'    => __( 'Typography', $domain ),
                'selector' => '{{WRAPPER}} .package-description',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => __( 'Color', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .package-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
        // Description end

        // Button
        $this->start_controls_section(
            'button_section',
            [
                'label' => __( 'Button', $domain ),
                'tab'   => Controls::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'button_title',
            [
                'label'   => __( 'Title', $domain ),
                'type'    => Controls::TEXTAREA,
                'default' => __( 'Start', $domain ),
            ]
        );
        $this->add_control(
            'button_url',
            [
                'label'   => __( 'URL', $domain ),
                'type'    => Controls::URL,
                'default' => [
                    'is_exeternal' => false,
                    'url'          => '#',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'button_border',
                'label'    => __( 'Border', $domain ),
                'selector' => '{{WRAPPER}} .package-button',
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label'           => __( 'Padding', $domain ),
                'type'            => Controls::DIMENSIONS,
                'size_units'      => ['px', '%'],
                'devices'         => ['mobile', 'tablet', 'desktop'],
                'mobile_default'  => [
                    'top'       => 10,
                    'right'     => 60,
                    'bottom'    => 10,
                    'left'      => 60,
                    'unit'      => 'px',
                    'is_linked' => false,
                ],
                'tablet_default'  => [
                    'top'       => 10,
                    'right'     => 60,
                    'bottom'    => 10,
                    'left'      => 60,
                    'unit'      => 'px',
                    'is_linked' => false,
                ],
                'desktop_default' => [
                    'top'       => 10,
                    'right'     => 60,
                    'bottom'    => 10,
                    'left'      => 60,
                    'unit'      => 'px',
                    'is_linked' => false,
                ],
                'selectors'       => [
                    '{{WRAPPER}} .package-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'button_styles' );
        // Normal styles
        $this->start_controls_tab(
            'button_normal_styles',
            [
                'label' => __( 'Normal', $domain ),
            ]
        );
        $this->add_control(
            'button_color',
            [
                'label'     => __( 'Color', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .package-button' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_fill_color',
            [
                'label'     => __( 'Fill', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#51a7f900',
                'selectors' => [
                    '{{WRAPPER}} .package-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        // Normal styles end

        // Hover styles
        $this->start_controls_tab(
            'button_hover_styles',
            [
                'label' => __( 'Hover', $domain ),
            ]
        );
        $this->add_control(
            'button_color_hover',
            [
                'label'     => __( 'Hover color', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .package-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_fill_hover_color',
            [
                'label'     => __( 'Fill hover', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#51a7f9',
                'selectors' => [
                    '{{WRAPPER}} .package-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        // Hover styles end
        $this->end_controls_tabs();

        $this->end_controls_section();
        // Button end

        // Period
        $this->start_controls_section(
            'period_section',
            [
                'label' => __( 'Period', $domain ),
                'tab'   => Controls::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'period',
            [
                'label'   => __( 'Text', $domain ),
                'type'    => Controls::TEXT,
                'default' => __( 'Billed annually', $domain ),
            ]
        );
        $this->add_control(
            'bottom_link_title',
            [
                'label'   => __( 'Bottom link title', $domain ),
                'type'    => Controls::TEXT,
                'default' => __( 'See all features in table', $domain ),
            ]
        );
        $this->add_control(
            'bottom_link_url',
            [
                'label'   => __( 'Bottom link url', $domain ),
                'type'    => Controls::URL,
                'default' => [
                    'url'         => '#',
                    'is_external' => false,
                ],
            ]
        );

        $this->start_controls_tabs( 'period_styles' );
        // Normal
        $this->start_controls_tab(
            'period_color_normal',
            [
                'label' => __( 'Normal', $domain ),
            ]
        );

        $this->add_control(
            'period_color',
            [
                'label'     => __( 'Color', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#51a7f9',
                'selectors' => [
                    '{{WRAPPER}} .package-period, {{WRAPPER}} .package-bottom-link' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        // Normal end

        // Hover
        $this->start_controls_tab(
            'period_color_hover',
            [
                'label' => __( 'Hover', $domain ),
            ]
        );
        $this->add_control(
            'period_hover_color',
            [
                'label'     => __( 'Color', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .package-bottom-link:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        // Hover end
        $this->end_controls_tabs();

        $this->end_controls_section();
        // Period end
    }

    /**
     * Render elements to the frontend
     *
     * @return void
     */
    protected function render() {
        $s      = $this->get_settings_for_display();
        $domain = 'geomify';

        $this->add_inline_editing_attributes( 'title', 'advanced' );
        $this->add_inline_editing_attributes( 'subtitle', 'advanced' );
        $this->add_inline_editing_attributes( 'description', 'advanced' );
        $this->add_inline_editing_attributes( 'button_title', 'advanced' );
        $this->add_inline_editing_attributes( 'period', 'advanced' );
        $this->add_inline_editing_attributes( 'bottom_link_title', 'advanced' );

        $this->add_render_attribute(
            'title',
            [
                'class' => 'package-title',
            ]
        );
        $this->add_render_attribute(
            'subtitle',
            [
                'class' => 'package-subtitle',
            ]
        );
        $this->add_render_attribute(
            'description',
            [
                'class' => 'package-description',
            ]
        );
        $this->add_render_attribute(
            'button_title',
            [
                'class'  => 'package-button',
                'href'   => $s['button_url']['url'],
                'target' => $s['button_url']['is_external'] ? '_blank' : '_self',
            ]
        );
        $this->add_render_attribute(
            'period',
            [
                'class' => 'package-period',
            ]
        );
        $this->add_render_attribute(
            'bottom_link_title',
            [
                'class'  => 'package-bottom-link',
                'href'   => $s['bottom_link_url']['url'],
                'target' => $s['bottom_link_url']['is_external'] ? '_blank' : '_self',
            ]
        );
        $this->add_render_attribute(
            'package_image',
            [
                'class' => 'package-image',
                'src'   => $s['package_image']['url'],
                'alt'   => __( 'Package logo', $domain ),
            ]
        );

        $title_attr             = $this->get_render_attribute_string( 'title' );
        $subtitle_attr          = $this->get_render_attribute_string( 'subtitle' );
        $description_attr       = $this->get_render_attribute_string( 'description' );
        $button_title_attr      = $this->get_render_attribute_string( 'button_title' );
        $period_attr            = $this->get_render_attribute_string( 'period' );
        $bottom_link_title_attr = $this->get_render_attribute_string( 'bottom_link_title' );
        $package_image_attr     = $this->get_render_attribute_string( 'package_image' );

        ob_start();
        include __DIR__ . '/views/Price_card/Price_card.php';
        echo ob_get_clean();
    }
}