<?php

namespace geomify\Widgets\Items\Elementor;

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
        return ['package table', 'price table', 'pricing plan'];
    }

    protected function _register_controls() {
        $domain = 'geomify';

        $this->start_controls_section(
            'general_settings',
            [
                'label' => __( 'General settings', $domain ),
                'tab'   => Controls::TAB_CONTENT,
            ]
        );
        
        $this->end_controls_section();
    }

    protected function render() {

    }
}