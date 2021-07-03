<?php

    namespace geomify\Widgets\Items\Elementor;

    use \Elementor\Controls_Manager as Controls;
    use \Elementor\Widget_Base as Base;

    class Videoplay extends Base {
        public function get_name() {
            return 'geomify-video-play';
        }

        public function get_title() {
            return __( 'Video play', 'geomify' );
        }

        public function get_icon() {
            return 'eicon-play-o';
        }

        public function get_categories() {
            return ['geomify'];
        }

        protected function _register_controls() {
            $this->start_controls_section(
                'button',
                [
                    'label' => __( 'Settings', 'geomify' ),
                    'tab'   => Controls::TAB_CONTENT,
                ]
            );
            $this->add_control(
                'button_url',
                [
                    'label'   => __( 'Button URL', 'geomify' ),
                    'type'    => Controls::URL,
                    'default' => [
                        'url'         => '#',
                        'is_external' => false,
                    ],
                ]
            );
            $this->add_control(
                'button_caption',
                [
                    'label'   => __( 'Button caption', 'geomify' ),
                    'type'    => Controls::TEXT,
                    'default' => __( 'Geomify button', 'geomify' ),
                ]
            );

            $this->add_responsive_control(
                'button_width',
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
                        'size' => 220,
                    ],
                    'tablet_default'  => [
                        'unit' => 'px',
                        'size' => 220,
                    ],
                    'mobile_default'  => [
                        'unit' => '%',
                        'size' => 80,
                    ],
                    'selectors'       => [
                        '{{WRAPPER}} .link-button' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_control(
                'button_color',
                [
                    'label'     => __( 'Color', 'geomify' ),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'default'   => '#000',
                    'selectors' => [
                        '{{WRAPPER}} .link-button' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'button_hover_color',
                [
                    'label'     => __( 'Hover color', 'geomify' ),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'default'   => '#fff',
                    'selectors' => [
                        '{{WRAPPER}} .link-button:hover' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'button_alignment',
                [
                    'label'           => __( 'Alignment', 'geomify' ),
                    'type'            => Controls::CHOOSE,
                    'devices'         => ['desktop', 'tablet', 'mobile'],
                    'options'         => [
                        'flex-start' => [
                            'title' => __( 'Left', 'geomify' ),
                            'icon'  => 'eicon-h-align-left',
                        ],
                        'center'     => [
                            'title' => __( 'Center', 'geomify' ),
                            'icon'  => 'eicon-h-align-center',
                        ],
                        'flex-end'   => [
                            'title' => __( 'Right', 'geomify' ),
                            'icon'  => 'eicon-h-align-right',
                        ],
                    ],
                    'desktop_default' => 'flex-start',
                    'tablet_default'  => 'flex-start',
                    'mobile_default'  => 'center',
                    'selectors'       => [
                        '{{WRAPPER}} .link-button' => 'align-self: {{VALUE}}',
                    ],
                ]

            );

            $this->end_controls_section();
            $this->start_controls_section(
                'video',
                [
                    'label' => __( 'Video', 'geomify' ),
                    'tab'   => Controls::TAB_CONTENT,
                ]
            );
            $this->add_control(
                'video_url',
                [
                    'label'       => __( 'Video URL', 'geomify' ),
                    'type'        => Controls::URL,
                    'default'     => [
                        'url'         => '#',
                        'is_external' => false,
                    ],
                    'description' => __( 'URL of the video of lightbox', 'geomify' ),
                ]
            );
            $this->add_control(
                'video_caption',
                [
                    'label'   => __( 'Video caption', 'geomify' ),
                    'type'    => Controls::TEXT,
                    'default' => __( 'Watch the video', 'geomify' ),
                ]
            );
            $this->add_control(
                'video_button_color',
                [
                    'label'     => __( 'Color', 'geomify' ),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'default'   => '#ccc',
                    'selectors' => [
                        '{{WRAPPER}} .video-button' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_responsive_control(
                'video_button_alignment',
                [
                    'label'           => __( 'Alignment', 'geomify' ),
                    'type'            => Controls::CHOOSE,
                    'devices'         => ['desktop', 'tablet', 'mobile'],
                    'options'         => [
                        'flex-start' => [
                            'title' => __( 'Left', 'geomify' ),
                            'icon'  => 'eicon-h-align-left',
                        ],
                        'center'     => [
                            'title' => __( 'Center', 'geomify' ),
                            'icon'  => 'eicon-h-align-center',
                        ],
                        'flex-end'   => [
                            'title' => __( 'Right', 'geomify' ),
                            'icon'  => 'eicon-h-align-right',
                        ],
                    ],
                    'desktop_default' => 'center',
                    'tablet_default'  => 'center',
                    'mobile_default'  => 'center',
                    'selectors'       => [
                        '{{WRAPPER}} .video-button' => 'align-self: {{VALUE}}',
                    ],
                ]

            );
            $this->end_controls_section();
            $this->start_controls_section(
                'sub_description_section',
                [
                    'label' => __( 'Sub description', 'geomify' ),
                    'tab'   => Controls::TAB_CONTENT,
                ]
            );
            $this->add_control(
                'sub_description',
                [
                    'label'   => __( 'Sub description', 'geomify' ),
                    'type'    => Controls::TEXT,
                    'default' => __( 'Sub description', 'geomify' ),
                ]
            );

            $this->add_control(
                'sub_description_color',
                [
                    'label'     => __( 'Color', 'geomify' ),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'default'   => '#aaa',
                    'selectors' => [
                        '{{WRAPPER}} .sub-description' => 'color: {{VALUE}}',
                    ],
                ]
            );
            $this->add_responsive_control(
                'sub_description_alignment',
                [
                    'label'           => __( 'Alignment', 'geomify' ),
                    'type'            => Controls::CHOOSE,
                    'devices'         => ['desktop', 'tablet', 'mobile'],
                    'options'         => [
                        'flex-start' => [
                            'title' => __( 'Left', 'geomify' ),
                            'icon'  => 'eicon-h-align-left',
                        ],
                        'center'     => [
                            'title' => __( 'Center', 'geomify' ),
                            'icon'  => 'eicon-h-align-center',
                        ],
                        'flex-end'   => [
                            'title' => __( 'Right', 'geomify' ),
                            'icon'  => 'eicon-h-align-right',
                        ],
                    ],
                    'desktop_default' => 'flex-end',
                    'tablet_default'  => 'flex-end',
                    'mobile_default'  => 'center',
                    'selectors'       => [
                        '{{WRAPPER}} .sub-description' => 'align-self: {{VALUE}}',
                    ],
                ]
            );
            $this->end_controls_section();
        }

        protected function render() {
            $s = $this->get_settings_for_display();

            $this->add_inline_editing_attributes( 'button_caption', 'basic' );
            $this->add_inline_editing_attributes( 'video_caption', 'basic' );
            $this->add_inline_editing_attributes( 'sub_description', 'basic' );

            $this->add_render_attribute(
                'button_caption',
                [
                    'class'  => 'link-button',
                    'target' => $s['button_url']['is_external'] == 'on' ? '_blank' : '_self',
                ]
            );

            $this->add_render_attribute(
                'video_caption',
                [
                    'class' => 'video-button',
                ]
            );

            $this->add_render_attribute(
                'sub_description',
                [
                    'class' => 'sub-description',
                ]
            );

        ?>
<div class="geomify-video-button-container">
    <a href="<?php echo $s['button_url']['url'] ?>"
        <?php echo $this->get_render_attribute_string( 'button_caption' ) ?>><?php echo $s['button_caption'] ?></a>
    <div                                 <?php echo $this->get_render_attribute_string( 'video_caption' ) ?>><?php echo $s['video_caption'] ?> <i
            class="far fa-play-circle"></i> </div>
    <div                                 <?php echo $this->get_render_attribute_string( 'sub_description' ) ?>><?php echo $s['sub_description'] ?></div>
</div>
<?php
    }

        protected function _content_template() {

    }
}