<?php

namespace geomify\Processor;

use geomify\geomify;
use geomify\Schema\Schema;
use \geomify\File\File as File;
use \geomify\Processor\Geomify_stripe as Gstripe;
use \geomify\Processor\Templates as Templates;
use \geomify\Processor\User as User;
use \geomify\Schema\CRUD as CRUD;

class Ajax {

    function __construct() {
        $this->register();
    }

    /**
     * Registers ajax requests
     *
     * @return void
     */
    public function register() {
        geomify_ajax( 'get_shortcode', [$this, 'get_shortcode'] );
        geomify_ajax( 'education_institue_form', [$this, 'education_institue_form'] );
        geomify_ajax( 'get_new_pv_form', [$this, 'get_new_pv_form'] );
        geomify_ajax( 'new_pv', [$this, 'new_pv'] );
        geomify_ajax( 'get_pv', [$this, 'get_pv'] );
        geomify_ajax( 'new_tutorial_page', [$this, 'new_tutorial_page'] );
        geomify_ajax( 'new_tutorial', [$this, 'new_tutorial'] );
        geomify_ajax( 'get_admin_tutorials', [$this, 'get_admin_tutorials'] );
        geomify_ajax( 'delete_tutorial', [$this, 'delete_tutorial'] );
        geomify_ajax( 'get_dashboard_tutorial_list', [$this, 'get_dashboard_tutorial_list'] );
        geomify_ajax( 'create_space', [$this, 'create_space'] );
        geomify_ajax( 'activate_user_finally', [$this, 'activate_user_finally'] );
        geomify_ajax( 'get_registration_form', [$this, 'get_registration_form'] );
        geomify_ajax( 'save_ac_info', [$this, 'save_ac_info'] );
        geomify_ajax( 'upgrade_license_page', [$this, 'upgrade_license_page'] );
        geomify_ajax( 'stripe_payment', [$this, 'stripe_payment'] );
        geomify_ajax( 'stripe_upgrade', [$this, 'stripe_upgrade'] );
        geomify_ajax( 'submit_enterprise_quote', [$this, 'submit_enterprise_quote'] );
        geomify_ajax( 'partner_programs_request_submit', [$this, 'partner_programs_request_submit'] );
        geomify_ajax( 'educational_institues_apply_submit', [$this, 'educational_institues_apply_submit'] );
        geomify_ajax( 'file_info_submit', [$this, 'file_info_submit'] );
        geomify_ajax( 'upload_geo_files', [$this, 'upload_geo_files'] );
        geomify_ajax( 'remove_pm', [$this, 'remove_pm'] );
        geomify_ajax( 'dlt_pv', [$this, 'dlt_pv'] );
        geomify_ajax( 'edit_pv_form', [$this, 'edit_pv_form'] );
        geomify_ajax( 'update_pv', [$this, 'update_pv'] );
        geomify_ajax( 'start_basic_form', [$this, 'start_basic_form'] );
        geomify_ajax( 'start_basic', [$this, 'start_basic'] );

    }

    /**
     * Returns shortcodes through ajax request
     *
     * @return void
     */
    public function get_shortcode() {
        wp_send_json_success(
            [
                'shortcode' => do_shortcode( geomify_var( 'shortcode' ) ),
            ]
        );

        exit;
    }

    /**
     * Educational institue apply form
     *
     * @return void
     */
    public function education_institue_form() {
        echo do_shortcode( $_POST['shortcode'] );
    }

    /**
     * New project view form/page
     *
     * @return void
     */
    public function get_new_pv_form() {
        if ( ! wp_verify_nonce( $_POST['nonce'], 'get_new_pv_form' ) ) {
            wp_send_json_error(
                [
                    'message' => __( 'Invalid token!', GTD ),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'form' => Templates::get( 'dashboard/project-views/new' ),
            ]
        );
        exit;
    }

    /**
     * Create a new project view
     *
     * @return void
     */
    public function new_pv() {
        if ( ! wp_verify_nonce( $_POST['nonce'], 'new_pv' ) ) {
            wp_send_json_error(
                [
                    'message' => __( 'Invalid token!', GTD ),
                ]
            );
            exit;
        }

        if ( ! User::is_current_user_admin() ) {
            wp_send_json_error(
                [
                    'msg' => __( "You're not an Admin!" ),
                ]
            );
            exit;
        }

        $insert_id = CRUD::create_from_post(
            'project_views',
            [
                'user_id' => User::current_user_id(),
            ]
        );

        if ( ! $insert_id ) {
            wp_send_json_error(
                [
                    'message' => __( 'There was an error while adding new project view', GTD ),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'message'      => __( 'Successfully added project view', GTD ),
                'success_page' => Templates::get( 'dashboard/project-views/success' ),
            ]
        );
        exit;
    }

    /**
     * Return project viiews list
     *
     * @return void
     */
    public function get_pv() {
        if ( ! wp_verify_nonce( $_POST['nonce'], 'get_pv' ) ) {
            wp_send_json_error(
                [
                    'message' => __( 'Invalid token!', GTD ),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'views' => Templates::get( 'dashboard/project-views/list' ),
            ]
        );
        exit;
    }

    /**
     * New tutorial page/form
     *
     * @return void
     */
    public function new_tutorial_page() {
        if ( ! wp_verify_nonce( geomify_var( 'nonce' ), 'new_tutorial_page' ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Invalid token!', GTD ),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'form' => Templates::get( 'admin/tutorials/new' ),
            ]
        );
        exit;
    }

    /**
     * Create a new tutorial
     *
     * @return void
     */
    public function new_tutorial() {
        $file_info = File::get_info(
            $_FILES['file'],
            [
                'dir' => GEOMIFY_TUTORIALS_PATH,
                'url' => GEOMIFY_TUTORIALS_URL,
            ]
        );

        File::move( $file_info );

        $insert_id = CRUD::create_from_post( 'tutorials',
            [
                'file_url'    => $file_info['url'],
                'file_path'   => $file_info['dir'],
                'file_info'   => serialize( $file_info ),
                'uploader_id' => User::current_user_id(),
                'uploaded_at' => $file_info['uploaded_at'],
            ]
        );

        if ( is_wp_error( $insert_id ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'There was an error adding new tutorial', GTD ),
                ]
            );
            exit;

        }

        wp_send_json_success(
            [
                'msg'  => __( 'New tutorial has been addedd.', GTD ),
                'list' => Templates::get( 'admin/tutorials/list' ),
            ]
        );
        exit;

    }

    /**
     * Get tutorial list for admin
     *
     * @return void
     */
    public function get_admin_tutorials() {
        if ( ! wp_verify_nonce( geomify_var( 'nonce' ), 'get_admin_tutorials' ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Invalid token!', GTD ),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'list' => Templates::get( 'admin/tutorials/list' ),
            ]
        );
        exit;
    }

    /**
     * Delete a tutorial
     *
     * @return void
     */
    public function delete_tutorial() {
        if ( ! wp_verify_nonce( geomify_var( 'nonce' ), 'delete_tutorial' ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Invalid token!', GTD ),
                ]
            );
            exit;
        }

        $tutorial = CRUD::retrieve( 'tutorials', geomify_var( 'id' ) );

        unlink( $tutorial->file_path );

        CRUD::delete( 'tutorials', geomify_var( 'id' ) );

        wp_send_json_success(
            [
                'msg' => __( 'Tutorial deleted!', GTD ),
            ]
        );
        exit;
    }

    /**
     * Return tutorials for user dashboard
     *
     * @return void
     */
    public function get_dashboard_tutorial_list() {
        if ( ! wp_verify_nonce( geomify_var( 'nonce' ), 'get_dashboard_tutorial_list' ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Invalid token!', GTD ),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'list' => Templates::get( 'dashboard/tutorials/list' ),
            ]
        );
        exit;
    }

    /**
     * Create a free subscription
     *
     * @return void
     */
    public function create_space() {
        if ( ! wp_verify_nonce( geomify_var( 'nonce' ), 'create_space' ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Invalid token!', GTD ),
                ]
            );
            exit;
        }

        $user_email = geomify_var( 'email' );
        $user_name  = geo_unique_username( $user_email );
        $time       = time();

        $userdata = [
            'user_login' => $user_name,
            'user_email' => $user_email,
            'first_name' => geomify_var( 'first_name' ),
            'last_name'  => geomify_var( 'last_name' ),
        ];

        if ( email_exists( $user_email ) ) {
            wp_send_json_error(
                [
                    'msg' => __( "You've already signed up!", GTD ),
                ]
            );
            exit;
        }

        $user_id = wp_insert_user( $userdata );

        $activation_id = $user_id . $time * 2;

        update_user_meta( $user_id, 'activated', false );
        update_user_meta( $user_id, 'activation_key', $activation_id );

        geo_session();
        $_SESSION['aurl'] = site_url( '/dashboard/activation?action=activate-account&user=' . $user_id . '&key=' . $activation_id );

        wp_mail(
            $user_email,
            'Account activation email',
            Templates::get( 'email/header' ) . Templates::get( 'email/account-activate' ) . Templates::get( 'email/footer' ),
            [
                'Content-Type: text/html; charset=UTF-8',
                sprintf( 'From: %s <admin@geomify.com>', get_bloginfo( 'name' ) ),
            ] );

        wp_send_json_success(
            [
                'page' => Templates::get( 'user/registration/success1' ),
            ]
        );
        exit;
    }

    /**
     * Activate an user from emailed activation link
     *
     * @return void
     */
    public function activate_user_finally() {
        if ( ! wp_verify_nonce( geomify_var( 'nonce' ), 'activate_user_finally' ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Invalid token!', GTD ),
                ]
            );
            exit;
        }

        $password         = geomify_var( 'password' );
        $confirm_password = geomify_var( 'confirm_password' );
        $user_id          = geomify_var( 'user_id' );
        $key              = geomify_var( 'key' );

        if ( $password !== $confirm_password ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Password mismatch!', GTD ),
                ]
            );
            exit;
        }

        if ( get_user_meta( $user_id, 'activation_key', true ) != $key ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Invalid activation key!', GTD ),
                ]
            );
            exit;
        }

        wp_set_password( $password, $user_id );

        update_user_meta( $user_id, 'activated', true );

        $user_login = get_user_by( 'ID', $user_id )->user_login;

        $userdata = [
            'user_login'    => $user_login,
            'user_password' => $password,
            'remember'      => true,
        ];

        $success = wp_signon( $userdata );

        User::initialize_stripe();

        if ( is_wp_error( $success ) ) {
            wp_send_json_error(
                [
                    'msg' => $success->get_error_message(),
                ]
            );
            exit;
        }

        wp_send_json_success();
        exit;
    }

    /**
     * Not in use!
     *
     * @return void
     */
    public function get_registration_form() {
        if ( ! wp_verify_nonce( geomify_var( 'nonce' ), 'get_registration_form' ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Invalid token!', GTD ),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'form' => Templates::get( 'user/registration/step1' ),
            ]
        );
        exit;
    }

    /**
     * Save user account informations
     *
     * Save from my profile section in user dashboard
     *
     * @return void
     */
    public function save_ac_info() {
        if ( ! wp_verify_nonce( geomify_var( 'nonce' ), 'save_ac_info' ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Invalid token!', GTD ),
                ]
            );
            exit;
        }

        $package_name = 'profile_' . geomify_var( 'package' );
        $fields       = Schema::get( $package_name );

        $values = Processor::seperate_values_from_schema( $fields, $_POST );

        if ( ! empty( $_POST['new_password'] ) && ! empty( $_POST['confirm_password'] ) ) {
            if ( $_POST['new_password'] !== $_POST['confirm_password'] ) {
                wp_send_json_error(
                    [
                        'msg' => __( 'Password mismatch', GTD ),
                    ]
                );
                exit;
            }

            wp_set_password( $_POST['new_password'], User::current_user_id() );

        }

        // update_user_meta( User::current_user_id(), $package_name, Processor::merge_package_info( geomify_var( 'package' ), $values ) );

        wp_send_json_success(
            [
                'wp_s' => $package_name,
                'd'    => $values,
                'msg'  => __( 'Settings saved', GTD ),
            ]
        );
        exit;
    }

    /**
     * Subscription package update page
     *
     * @return void
     */
    public function upgrade_license_page() {

        if ( ! wp_verify_nonce( geomify_var( 'nonce' ), 'upgrade_license_page' ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Invalid token!', GTD ),
                ]
            );
            exit;
        }

        if ( ! Gstripe::is_current_user_have_pm() ) {
            wp_send_json_success(
                [
                    'form' => Templates::get( 'payment/pay' ),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'form' => Templates::get( 'payment/upgrade' ),
            ]
        );
        exit;
    }

    /**
     * Stripe payment gateway
     *
     * Stripe subscription upgrade
     *
     * Stripe payment form/page
     *
     * @return void
     */
    public function stripe_payment() {
        if ( ! wp_verify_nonce( geomify_var( 'nonce' ), 'stripe_payment' ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Invalid token!', GTD ),
                ]
            );exit;
        }

        $package_name           = geomify_var( 'package_name' );
        $package                = Schema::get( 'packages' )[$package_name];
        $type                   = geomify_var( 'type' );
        $stripe_customer_id     = User::stripe_customer_id();
        $stripe_subscription_id = User::stripe_subscription_id();
        $success                = true;

        switch ( $type ) {
            case 'card':
                $card_number  = geomify_var( 'card_number' );
                $expire_month = geomify_var( 'expire_month' );
                $expire_year  = geomify_var( 'expire_year' );
                $cvc          = geomify_var( 'cvc' );

                $payment_method_id = Gstripe::create_payment_method(
                    [
                        'type' => 'card',
                        'card' => [
                            'number'    => $card_number,
                            'exp_month' => $expire_month,
                            'exp_year'  => $expire_year,
                            'cvc'       => $cvc,
                        ],
                    ]
                )->id;

                Gstripe::attach_payment_method(
                    $payment_method_id,
                    $stripe_customer_id
                );

                User::set_meta( 'stripe_payment_method_id', $payment_method_id );

                Gstripe::update_customer(
                    $stripe_customer_id,
                    [
                        'invoice_settings' => [
                            'default_payment_method' => $payment_method_id,
                        ],
                    ]
                );

                $old_subscriptions   = User::get_meta( 'stripe_subscriptions', [] );
                $old_subscriptions[] = $package_name;
                User::set_meta( 'stripe_subscriptions', $old_subscriptions );

                // wp_send_json_error(Gstripe::package( $package_name ) );exit;

                $subscription = Gstripe::update_subscription( $stripe_subscription_id, Gstripe::package( $package_name ) );

                break;
            default:
                break;
        }

        if ( $success ) {
            wp_send_json_success(
                [
                    'page' => Templates::get( 'payment/upgrade_success' ),
                ]
            );
            exit;
        }

        wp_send_json_error(
            [
                'msg' => __( 'There was an error upgrading your package, try again please', GTD ),
            ]
        );
        exit;
    }

    /**
     * Upgrade subscription package through ajax
     *
     * @return void
     */
    public function stripe_upgrade() {
        if ( ! wp_verify_nonce( geomify_var( 'nonce' ), 'stripe_upgrade' ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Invlaid token!', GTD ),
                ]
            );
            exit;
        }

        if ( ! Gstripe::is_current_user_have_pm() ) {
            wp_send_json_error(
                [
                    'msg' => __( 'You don\'nt have any payment method!', GTD ),
                ]
            );
            exit;
        }

        $package_name           = geomify_var( 'package_name' );
        $package                = Schema::get( 'packages' )[$package_name];
        $stripe_customer_id     = User::get_meta( 'stripe_customer_id' );
        $stripe_subscription_id = User::get_meta( 'stripe_subscription_id' );

        if ( in_array( $package_name, User::get_meta( 'stripe_subscriptions' ) ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'You already own this package!', GTD ),
                ]
            );
            exit;
        }

        Gstripe::update_subscription(
            $stripe_subscription_id,
            Gstripe::package( $package_name )
        );

        // wp_send_json_error(
        //     'test'
        // );exit;
        $old_subscriptions   = (array) User::get_meta( 'stripe_subscriptions' );
        $old_subscriptions[] = $package_name;
        User::set_meta( 'stripe_subscriptions', $old_subscriptions );

        wp_send_json_success(
            [
                'page' => Templates::get( 'payment/upgrade_success' ),
            ]
        );
        exit;
    }

    /**
     * Enterprise quote submission
     *
     * @return void
     */
    public function submit_enterprise_quote() {
        if ( ! wp_verify_nonce( geomify_var( 'nonce' ), 'submit_enterprise_quote' ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Invalid token!' ),
                ]
            );
            exit;
        }

        $inserted = CRUD::create_from_post(
            'enterprise_quotes',
            [
                'time' => time(),
            ]
        );

        if ( is_wp_error( $inserted ) ) {
            wp_send_json_error(
                [
                    'msg' => $inserted->get_error_message(),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'page' => Templates::get( 'enterprise/quote-success' ),
            ]
        );exit;
    }

    /**
     * Partner programs request submission
     *
     * @return void
     */
    public function partner_programs_request_submit() {

        if ( ! wp_verify_nonce( geomify_var( 'nonce' ), 'partner_programs_request_submit' ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Invalid token!' ),
                ]
            );
            exit;
        }

        extract( $_POST );

        $inserted = CRUD::create_from_post(
            'partner_programs_request',
            [
                'time' => time(),
            ]
        );

        if ( is_wp_error( $inserted ) ) {
            wp_send_json_error(
                [
                    'msg' => $inserted->get_error_message(),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'template' => do_shortcode( $shortcode ),
            ]
        );
        exit;
    }

    /**
     * Educational institues apply submission
     *
     * @return void
     */
    public function educational_institues_apply_submit() {
        if ( ! wp_verify_nonce( geomify_var( 'nonce' ), 'educational_institues_apply_submit' ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Invalid token!' ),
                ]
            );
            exit;
        }

        extract( $_POST );

        $inserted = CRUD::create_from_post( 'educational_institutes_requests',
            [
                'time' => time(),
            ]
        );

        if ( is_wp_error(  ( $inserted ) ) ) {
            wp_send_json_error(
                [
                    'msg' => $inserted->get_error_message(),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'template' => do_shortcode( $shortcode ),
            ]
        );
        exit;
    }

    /**
     * Geo files info submit section
     *
     * Insert data from frontend for geo_files_info table
     *
     * @return void
     */
    public function file_info_submit() {
        if ( wp_verify_nonce( geomify_var( 'nonce' ), 'file_info_submit_nonce' ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Invalid token!' ),
                ]
            );
            exit;
        }

        $inserted = CRUD::create_from_post(
            'geo_files_info',
            [
                'created_at' => time(),
                'user_id'    => User::id(),
            ]
        );

        if ( is_wp_error( $inserted ) ) {
            wp_send_json_error(
                [
                    'msg' => $inserted->get_error_message(),
                ]
            );
            exit;
        }

        $_SESSION['file_info_id'] = $inserted;

        wp_send_json_success(
            [
                'msg' => __( 'File submission created' ),
            ]
        );
        exit;

    }

    /**
     * User file upload management
     *
     * @return void
     */
    public function upload_geo_files() {
        if ( ! wp_verify_nonce( geomify_var( 'nonce' ), 'upload_geo_files' ) || ! isset( $_SESSION['file_info_id'] ) ) {
            wp_send_json_error(

                [
                    'a'   => isset( $_SESSION['file_info_id'] ),
                    'b'   => wp_verify_nonce( geomify_var( 'nonce' ), 'upload_geo_files' ),
                    'msg' => __( 'Invalid token!' ),
                ]
            );
            exit;
        }

        $file_info = File::get_info(
            $_FILES['file'],
            [
                'dir' => GEOMIFY_FILES_DIR . 'geo-files/',
                'url' => GEOMIFY_FILES_URL . 'geo-files/',
            ]
        );

        $inserted = CRUD::create(
            'geo_files',
            [
                'file_url'    => $file_info['url'],
                'file_path'   => $file_info['dir'],
                'file_info'   => serialize( $file_info ),
                'uploaded_at' => time(),
                'geo_id'      => $_SESSION['file_info_id'],
            ]
        );

        if ( is_wp_error( $inserted ) ) {
            wp_send_json_error(
                [
                    'msg' => $inserted->get_error_message(),
                ]
            );
            exit;
        }

        $sc = move_uploaded_file( $file_info['tmp_name'], $file_info['dir'] );

        wp_send_json_success(
            [
                'msg' => __( 'File uploaded' ),
                'sc'  => $_FILES['file'],
            ]
        );
        exit;

    }

    /**
     * Removes a payment method through ajax request
     *
     * @return void
     */
    public function remove_pm() {
        if ( ! wp_verify_nonce( geomify_var( 'nonce' ), 'remove_pm' ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Invalid token!' ),
                ]
            );
            exit;
        }

        Gstripe::detach_payment_method( $_POST['id'] );

        wp_send_json_success(
            [
                'msg' => 'Payment method removed',
            ]
        );
        exit;
    }

    /**
     * Delete a project view
     *
     * @return void
     */
    public function dlt_pv() {
        if ( ! wp_verify_nonce( geomify_var( 'nonce' ), 'dlt_pv' ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Invalid token' ),
                ]
            );
            exit;
        }

        CRUD::delete(
            'project_views',
            $_POST['id']
        );

        wp_send_json_success(
            [
                'msg' => __( 'Project view deleted' ),
            ]
        );
        exit;
    }

    /**
     * Edit project view form
     *
     * @return void
     */
    public function edit_pv_form() {
        wp_send_json_success(
            [
                'form' => Templates::get( 'dashboard/project-views/edit' ),
            ]
        );
        exit;
    }

    /**
     * Update edited project view
     *
     * @return void
     */
    public function update_pv() {
        if ( ! wp_verify_nonce( geomify_var( 'nonce' ), 'update_pv' ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Invalid token!' ),
                ]
            );
            exit;
        }

        $updated = CRUD::update_from_post( 'project_views', isset( $_POST['id'] ) ? $_POST['id'] : 0 );

        if ( is_wp_error( $updated ) ) {
            wp_send_json_error(
                [
                    'msg' => $updated->get_error_message(),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'msg' => __( 'Project view updated' ),
            ]
        );
        exit;
    }

    public function start_basic_form() {
        if ( ! wp_verify_nonce( geomify_var( 'nonce' ), 'start_basic_form' ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Invalid token!' ),
                ]
            );
            exit;
        }

        $_POST['package_name'] = 'basic';

        // For logged in user
        if ( User::is_logged() ) {
            if ( User::have_subscription( 'basic' ) ) {
                wp_send_json_error(
                    [
                        'You\'ve already subscribed to basic',
                    ]
                );
                exit;
            }
            // If user haven't payment method added
            if ( ! Gstripe::is_current_user_have_pm() ) {
                wp_send_json_success(
                    [
                        'form' => Templates::get( 'payment/pay' ),
                    ]
                );
                exit;
            }

            // If user have payment method added
            wp_send_json_success(
                [
                    'form' => Templates::get( 'payment/upgrade' ),
                ]
            );
            exit;
        }

        // If user isn't logged in

        wp_send_json_success(
            [
                'form' => Templates::get( 'payment/start-basic' ),
            ]
        );
        exit;
    }

    public function start_basic() {
        if ( ! wp_verify_nonce( geomify_var( 'nonce' ), 'start_basic' ) ) {
            wp_send_json_error(
                [
                    'msg' => __( 'Invalid token!' ),
                ]
            );
            exit;
        }

        extract( $_POST );

        $user_name = geo_unique_username( $email );
        $time      = time();

        $userdata = [
            'user_login' => $user_name,
            'user_email' => $email,
            'first_name' => $first_name,
            'last_name'  => $last_name,
        ];

        if ( email_exists( $email ) ) {
            wp_send_json_error(
                [
                    'msg' => __( "You've already signed up!", GTD ),
                ]
            );
            exit;
        }

        $user_id = wp_insert_user( $userdata );

        $activation_id = $user_id . $time * 2;

        update_user_meta( $user_id, 'activated', false );
        update_user_meta( $user_id, 'activation_key', $activation_id );

        geo_session();
        $_SESSION['aurl'] = site_url( '/dashboard/activation?action=activate-account&user=' . $user_id . '&key=' . $activation_id );

        wp_mail(
            $email,
            'Account activation email',
            Templates::get( 'email/header' ) . Templates::get( 'email/account-activate' ) . Templates::get( 'email/footer' ),
            [
                'Content-Type: text/html; charset=UTF-8',
                sprintf( 'From: %s <admin@geomify.com>', get_bloginfo( 'name' ) ),
            ] );

        wp_send_json_success(
            [
                'page' => Templates::get( 'payment/start-basic-success' ),
            ]
        );

    }

}
