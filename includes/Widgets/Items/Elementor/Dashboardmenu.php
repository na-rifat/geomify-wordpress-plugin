<?php

namespace geomify\Widgets\Items\Elementor;

defined( 'ABSPATH' ) or exit;

use \Elementor\Controls_Manager as Controls;
use \Elementor\Repeater as Repeater;
use \Elementor\Widget_Base as Base;

class Dashboardmenu extends Base {
    public function get_name() {
        return 'geomify_dashboard_menu';
    }

    public function get_title() {
        return __( 'Dashboard menu', 'geomify' );
    }

    public function get_categories() {
        return ['geomify'];
    }

    public function get_keywords() {
        return ['dashboard', 'menu', 'geomify', 'dashboard menu'];
    }

    public function get_icon() {
        return 'eicon-menu-bar';
    }

    public function get_script_depends() {
        return ['geomify-widgets-script'];
    }

    public function get_style_depends() {
        return ['geomify-widgets-style'];
    }

    protected function _register_controls() {
        $domain = GEOMIFY_TEXT_DOMAIN;
        // General settings
        $this->start_controls_section(
            'general_options',
            [
                'label' => __( 'General', $domain ),
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

        $menus = new Repeater();

        $menus->add_control(
            'menu_title',
            [
                'label'       => __( 'Title', $domain ),
                'type'        => Controls::TEXT,
                'placeholder' => __( 'Menu title', $domain ),
                'description' => __( 'Title of the menu', $domain ),
            ]
        );

        $menus->add_control(
            'menu_icon',
            [
                'label'       => __( 'Icon name', $domain ),
                'type'        => Controls::TEXT,
                'description' => __( 'Image file name for specific icon', $domain ),
            ]
        );

        $menus->add_control(
            'menu_slug',
            [
                'label'       => __( 'Slug', $domain ),
                'type'        => Controls::TEXT,
                'description' => __( 'Slug of the dashboard page', $domain ),
            ]
        );

        $menus->add_control(
            'is_active',
            [
                'label'        => __( 'Active?', $domain ),
                'type'         => Controls::SWITCHER,
                'label_on'     => __( 'Yes', $domain ),
                'label_off'    => __( 'No', $domain ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->add_control(
            'menu_items',
            [
                'label'       => __( 'Menu items', $domain ),
                'type'        => Controls::REPEATER,
                'fields'      => $menus->get_controls(),
                'title_field' => '{{{menu_title}}}',
                'default'     => [
                    [
                        'menu_title' => __( 'Menu item', $domain ),
                        'menu_icon'  => 'eicon-dashboard',
                    ],
                ],
            ]
        );

        $this->end_controls_section();
        // General settings end

        // General styles
        $this->start_controls_section(
            'general_styles',
            [
                'label' => __( 'General', $domain ),
                'tab'   => Controls::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'menu_align',
            [
                'label'           => __( 'Align', $domain ),
                'type'            => Controls::CHOOSE,
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
                'devices'         => [
                    'mobile',
                    'tablet',
                    'desktop',
                ],
                'mobile_default'  => 'center',
                'tablet_default'  => 'right',
                'desktop_default' => 'right',
                'selectors'       => [
                    '{{WRAPPER}} .geomify-dashboard-menu' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'menu_width',
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
                        'max' => 600,
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
                    'unit' => 'px',
                    'size' => 400,
                ],
                'tablet_default'  => [
                    'unit' => 'px',
                    'size' => 400,
                ],
                'desktop_default' => [
                    'unit' => 'px',
                    'size' => 400,
                ],
                'selectors'       => [
                    '{{WRAPPER}} ul' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        // General styles end
    }

    protected function render() {
        $s      = $this->get_settings_for_display();
        $domain = GEOMIFY_TEXT_DOMAIN;

        $menu_el = '';

        foreach ( $s['menu_items'] as $item ) {
            $menu_el .= sprintf(
                '<li><a class="%s" href="%s"><img src="%s" />%s</a></li>',
                $item['is_active'] === 'yes' ? 'active-item' : '',
                $item['menu_slug'],
                GEOMIFY_ASSETS_URL . '/img/icons/' . $item['menu_icon'],
                $item['menu_title']
            );
        }

        printf( '<div class="geomify-dashboard-menu" data-browser="%s" ><ul>%s</ul></div>', $s['browser_id'], $menu_el );
    }
}