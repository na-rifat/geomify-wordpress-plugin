<?php

namespace geomify\Widgets\Items\Elementor;

defined( 'ABSPATH' ) or exit;
use Elementor\Controls_Manager as Controls;
use Elementor\Widget_Base as Base;

class Secondary_news extends Base {
    public function get_name() {
        return 'geomify_secondary_news';
    }

    public function get_title() {
        return __( 'Secondary news', 'geomify' );
    }

    public function get_categories() {
        return ['geomify'];
    }

    public function get_keywords() {
        return ['geomify', 'geomify news', 'news', 'post', 'geomify secondary news', 'secondary news'];
    }

    public function get_script_depends() {
        return ['geomify-widgets-script'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'general',
            [
                'label' => __( 'General', 'geomify' ),
                'tab'   => Controls::TAB_CONTENT,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

    }
}