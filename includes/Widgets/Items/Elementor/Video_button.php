<?php

namespace geomify\Widgets\Items\Elementor;

use Elementor\Controls_Manager as Controls;
use Elementor\Widget_Base as Base;

class Video_button extends Base {
    public function get_script_depends() {
        return ['geomify-widgets-script'];
    }

    public function get_name() {
        return 'geomify_video_button';
    }

    public function get_title() {
        return __( 'Video button', 'geomify' );
    }

    public function get_categories() {
        return ['geomify'];
    }

    public function get_keywords() {
        return ['video button', 'play button', 'geomify'];
    }

    protected function _register_controls() {
        $domain = 'geomify';

        // General
        $this->start_controls_section(
            'general_settings',
            [
                'label' => __( 'General', $domain ),
                'tab'   => Controls::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label'       => __( 'Title', $domain ),
                'label_block' => true,
                'description' => __( 'Title show at the top of the button', $domain ),
                'type'        => Controls::TEXT,
                'default'     => __( 'Watch the video', $domain ),
            ]
        );

        $this->add_control(
            'video_source_type',
            [
                'label'       => __( 'Video source type', $domain ),
                'label_block' => false,
                'type'        => Controls::SELECT,
                'options'     => [
                    'youtube'     => __( 'Youtube', $domain ),
                    'self_hosted' => __( 'Self hosted', $domain ),
                ],
                'default'     => 'youtube',
            ]
        );

        $this->add_control(
            'youtube_video_url',
            [
                'label'       => __( 'Youtube video url', $domain ),
                'label_block' => true,
                'type'        => Controls::TEXT,
                'default'     => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
                'condition'   => [
                    'video_source_type' => 'youtube',
                ],
            ]
        );

        $this->add_control(
            'self_hosted_video_url',
            [
                'label'       => __( 'Self hosted video url', $domain ),
                'label_block' => true,
                'type'        => 'text',
                'default'     => '',
                'condition'   => [
                    'video_source_type' => 'self_hosted',
                ],
            ]
        );

        $this->end_controls_section();
        // General ended

        // Styles
        $this->start_controls_section(
            'style_settings',
            [
                'label' => __( 'Styles', $domain ),
                'tab'   => Controls::TAB_CONTENT,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'button_typography',
                'label'    => __( 'Typography', $domain ),
                'selector' => '{{WRAPPER}} .geomify-video-button',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __( 'Title color', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .geomify-video-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label'     => __( 'Title hover color', $domain ),
                'type'      => Controls::COLOR,
                'default'   => '#cccccc',
                'selectors' => [
                    '{{WRAPPER}} .geomify-video-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'alignment',
            [
                'label'     => __( 'Alignment', $domain ),
                'type'      => Controls::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __( 'Left', 'plugin-domain' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'plugin-domain' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'  => [
                        'title' => __( 'Right', 'plugin-domain' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
        // Styles ended

    }

    protected function render() {
        $s = $this->get_settings_for_display();

        $this->add_inline_editing_attributes( 'title', 'advanced' );
        $this->add_render_attribute(
            'title',
            [
                'class'                  => 'geomify-video-button',
                'data-video-url'         => $s['video_source_type'] == 'youtube' ? geomify_y2embed( $s['youtube_video_url'] ) : $s['self_hosted_video_url'],
                'data-video-source-type' => $s['video_source_type'],
            ]
        );
        $attr = $this->get_render_attribute_string( 'title' );

        printf( '<div %s >%s <i class="far fa-play-circle"></i></i></div>', $attr, $s['title'] );
    }

}
