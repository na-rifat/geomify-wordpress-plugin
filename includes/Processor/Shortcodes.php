<?php

namespace geomify\Processor;

use \geomify\Processor\Multiform as Form;
use \geomify\Processor\Templates as Templates;
use \geomify\Schema\Schema as Schema;

class Shortcodes {

    function __construct() {

    }

    public function register() {
        add_shortcode( 'geomify-header', [$this->templates, 'header'] );
        add_shortcode( 'geomify-footer', [$this->templates, 'footer'] );
        add_shortcode( 'geomify-start-free-form', [$this, 'start_free_form'] );
        add_shortcode( 'geomify-educational-institues-form', [$this, 'educational_instutues_form'] );
        add_shortcode( 'geomify-project-views', [$this, 'dashboard_project_views'] );
        add_shortcode( 'geomify-my-profile', [$this, 'dashboard_my_profile'] );
        add_shortcode( 'geomify-support', [$this, 'dashboard_support'] );
        add_shortcode( 'geomify-tutorials', [$this, 'dashboard_tutorials'] );
        add_shortcode( 'geomify-registration', [$this, 'geomify_registration'] );
        add_shortcode( 'geomify-account-activation', [$this, 'account_activation'] );
        add_shortcode( 'unlock-basic-text', [$this, 'unlock_basic_text'] );
        add_shortcode( 'license-login-page', [$this, 'license_login_page'] );
        add_shortcode( 'unlock-basic-fu-title', [$this, 'unlock_basic_fu_title'] );

        add_shortcode( 'geomify-home-button', [$this, 'geomify_home_button'] );
        add_shortcode( 'geomify-startfree-button', [$this, 'geomify_startfree_button'] );
        add_shortcode( 'start-free-url', [$this, 'start_free_url'] );
        add_shortcode( 'start-basic-url', [$this, 'start_basic_url'] );
        add_shortcode( 'read-more-url', [$this, 'read_more_url'] );
        add_shortcode( 'contact-us-url', [$this, 'contact_us_url'] );
        add_shortcode( 'contact-phone', [$this, 'contact_phone'] );
        add_shortcode( 'newsletter-activation', [$this, 'newsletter_activation'] );
        add_shortcode( 'enterprise_get_quote', [$this, 'enterprise_get_quote'] );
        add_shortcode('apply-partner-program', [$this, 'apply_partner_programs']);
    }

    public function init() {
        $this->register();
    }

    /**
     * Start free form
     *
     * @return string
     */
    public function start_free_form() {
        $domain = GEOMIFY_TEXT_DOMAIN;
        $form   = new Form();

        $form->start_step();

        $form->create_field(
            [
                'name'  => 'email',
                'label' => __( 'Email address', $domain ),
                'type'  => 'email',
            ]
        );

        $form->create_field_pair(
            [
                'name'  => 'first_name',
                'label' => __( 'First name', $domain ),
            ],
            [
                'name'  => 'last_name',
                'label' => __( 'Last name', $domain ),
            ]
        );

        $form->end_step();

        $element = $form->get();

        return $element;
    }

    /**
     * Educational institues form
     *
     * @return string
     */
    public function educational_instutues_form() {
        $domain     = GEOMIFY_TEXT_DOMAIN;
        $form       = new Form();
        $fields     = Schema::get( 'educational_institutes_requests' );
        $fields     = Processor::add_name_to_inputs( $fields );
        $form->name = 'educational_institues_apply';

        $form->globals['use_label'] = true;

        $form->start_step();
        $form->create_field( $fields['educational_institue'] );
        $form->create_field( $fields['location'] );
        $form->create_field( $fields['street_address'] );
        $form->create_field_pair( $fields['zip_code'], $fields['city'] );
        $form->end_step();

        $form->start_step();
        $form->create_field_pair( $fields['contact_first'], $fields['contact_last'] );
        $form->create_field( $fields['email'] );
        $form->create_field( $fields['mobile'] );
        $form->end_step();

        return $form->get();
    }

    public function dashboard_project_views() {
        return Templates::get( 'dashboard/project-views/index' );
    }

    public function dashboard_my_profile() {
        return Templates::get( 'dashboard/my-profile/index' );
    }

    public function dashboard_support() {
        return Templates::get( 'dashboard/support/index' );
    }

    public function dashboard_tutorials() {
        return Templates::get( 'dashboard/tutorials/index' );
    }

    public function geomify_registration( $atts ) {
        $defaults = [
            'id' => 1,
        ];

        $atts = wp_parse_args( $atts, $defaults );

        switch ( $atts['id'] ) {
            case 1:
                return Templates::get( 'user/registration/step1' );
                break;
            default:
                break;
        }
    }

    public function account_activation() {
        return Templates::get( 'user/activation/index' );
    }

    public function unlock_basic_text() {
        $subscriptions = (array) User::get_meta( 'stripe_subscriptions' );

        if ( ! in_array( 'basic', $subscriptions ) ) {
            return '<i class="fas fa-lock"></i> UNLOCK BASIC';
        }

        return '<div class="basic-unlocked"><i class="fas fa-lock-open"></i> BASIC <span class="blue-text">&nbsp;UNCLOKED</span></div>';
    }

    public function license_login_page() {
        return Templates::get( 'user/license_login' );
    }

    public function unlock_basic_fu_title() {
        $subscriptions = (array) User::get_meta( 'stripe_subscriptions' );

        if ( ! in_array( 'basic', $subscriptions ) ) {
            return '<div class="upgrade-basic upgrade-not-complete"><i class="fas fa-lock"></i> UNLOCK BASIC</div>';
        }

        return '<div class="upgrade-complete"><i class="fas fa-upload"></i> File upload</div>';
    }

    public function geomify_home_button() {
        return sprintf(
            '<div class="home-button-holder">
                <div class="home-button-item blue-text">
                Browse Built-in World Terrain from Cesium
                %s
                </div>
                <div class="divid">|</div>
                <div class="home-button-item blue-text">
                    %s
                    Load Maps, GEO data & OSM buildings
                </div>
            </div>',
            geomify_cesium_icon( 30, 30 ),
            geomify_osm_icon( 30, 30 )
        );
    }

    public function geomify_startfree_button() {
        return sprintf(
            '<div class="home-button-holder">
                <div class="home-button-item blue-text">
                CESIUM WORLD TERRAIN
                %s
                </div>
                <div class="divid">|</div>
                <div class="home-button-item blue-text">
                    %s
                    MAPS, GEO & OSM BUILDINGS
                </div>
            </div>',
            geomify_cesium_icon( 30, 30 ),
            geomify_osm_icon( 30, 30 )
        );
    }

    public function start_free_url() {
        return site_url( '/start-free' );
    }

    public function start_basic_url() {
        return site_url( '/start-free' );
    }

    public function read_more_url() {
        return site_url( '/news' );
    }

    public function contact_us_url() {
        return site_url( '/contact-us' );
    }

    public function contact_phone() {
        return '+123 456 789';
    }

    public function newsletter_activation() {
        return Templates::get( '/newsletter/activation' );
    }

    public function enterprise_get_quote() {
        return Templates::get( '/enterprise/get-quote' );
    }

    public function apply_partner_programs(){
        return Templates::get('partner-programs/apply');
    }    

}