<?php

namespace geomify\Processor;

use geomify\Schema\Schema;
use \geomify\File\File as File;
use \geomify\Processor\Geomify_stripe as Gstripe;
use \geomify\Processor\Templates as Templates;
use \geomify\Processor\User as User;
use \geomify\Schema\CRUD as CRUD;

class Ajax
{

    function __construct()
    {
        $this->register();
    }

    /**
     * Registers ajax requests
     *
     * @return void
     */
    public function register()
    {
        geomify_ajax('get_shortcode', [$this, 'get_shortcode']);
        geomify_ajax('education_institue_form', [$this, 'education_institue_form']);
        geomify_ajax('get_new_pv_form', [$this, 'get_new_pv_form']);
        geomify_ajax('new_pv', [$this, 'new_pv']);
        geomify_ajax('get_pv', [$this, 'get_pv']);
        geomify_ajax('new_tutorial_page', [$this, 'new_tutorial_page']);
        geomify_ajax('new_tutorial', [$this, 'new_tutorial']);
        geomify_ajax('get_admin_tutorials', [$this, 'get_admin_tutorials']);
        geomify_ajax('delete_tutorial', [$this, 'delete_tutorial']);
        geomify_ajax('get_dashboard_tutorial_list', [$this, 'get_dashboard_tutorial_list']);
        geomify_ajax('create_space', [$this, 'create_space']);
        geomify_ajax('activate_user_finally', [$this, 'activate_user_finally']);
        geomify_ajax('get_registration_form', [$this, 'get_registration_form']);
        geomify_ajax('save_ac_info', [$this, 'save_ac_info']);
        geomify_ajax('upgrade_license_page', [$this, 'upgrade_license_page']);
        geomify_ajax('stripe_payment', [$this, 'stripe_payment']);
        geomify_ajax('stripe_upgrade', [$this, 'stripe_upgrade']);
        geomify_ajax('submit_enterprise_quote', [$this, 'submit_enterprise_quote']);
        geomify_ajax('partner_programs_request_submit', [$this, 'partner_programs_request_submit']);
        geomify_ajax('educational_institues_apply_submit', [$this, 'educational_institues_apply_submit']);
        geomify_ajax('file_info_submit', [$this, 'file_info_submit']);
        geomify_ajax('upload_geo_files', [$this, 'upload_geo_files']);
        geomify_ajax('remove_pm', [$this, 'remove_pm']);
        geomify_ajax('dlt_pv', [$this, 'dlt_pv']);
        geomify_ajax('edit_pv_form', [$this, 'edit_pv_form']);
        geomify_ajax('update_pv', [$this, 'update_pv']);
        geomify_ajax('start_basic_form', [$this, 'start_basic_form']);
        geomify_ajax('start_basic', [$this, 'start_basic']);
        geomify_ajax('geo_login', [$this, 'geo_login']);
        geomify_ajax('geo_reset', [$this, 'geo_reset']);
        geomify_ajax('geo_pass_reset', [$this, 'geo_pass_reset']);
        geomify_ajax('save_geo_options', [$this, 'save_geo_options']);
        geomify_ajax('dlt_geo_file', [$this, 'dlt_geo_file']);
        geomify_ajax('view_geo_file', [$this, 'view_geo_file']);
        geomify_ajax('geo_admin_login', [$this, 'geo_admin_login']);
    }

    /**
     * Returns shortcodes through ajax request
     *
     * @return void
     */
    public function get_shortcode()
    {
        wp_send_json_success(
            [
                'shortcode' => do_shortcode(geomify_var('shortcode')),
            ]
        );

        exit;
    }

    /**
     * Educational institue apply form
     *
     * @return void
     */
    public function education_institue_form()
    {
        echo do_shortcode($_POST['shortcode']);
    }

    /**
     * New project view form/page
     *
     * @return void
     */
    public function get_new_pv_form()
    {
        if (!wp_verify_nonce($_POST['nonce'], 'get_new_pv_form')) {
            wp_send_json_error(
                [
                    'message' => __('Invalid token!', GTD),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'form' => Templates::get('dashboard/project-views/new'),
            ]
        );
        exit;
    }

    /**
     * Create a new project view
     *
     * @return void
     */
    public function new_pv()
    {
        if (!wp_verify_nonce($_POST['nonce'], 'new_pv')) {
            wp_send_json_error(
                [
                    'message' => __('Invalid token!', GTD),
                ]
            );
            exit;
        }

        if (!User::is_current_user_admin()) {
            wp_send_json_error(
                [
                    'msg' => __("You're not an Admin!"),
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

        if (!$insert_id) {
            wp_send_json_error(
                [
                    'message' => __('There was an error while adding new project view', GTD),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'message'      => __('Successfully added project view', GTD),
                'success_page' => Templates::get('dashboard/project-views/success'),
            ]
        );
        exit;
    }

    /**
     * Return project viiews list
     *
     * @return void
     */
    public function get_pv()
    {
        if (!wp_verify_nonce($_POST['nonce'], 'get_pv')) {
            wp_send_json_error(
                [
                    'message' => __('Invalid token!', GTD),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'views' => Templates::get('dashboard/project-views/list'),
            ]
        );
        exit;
    }

    /**
     * New tutorial page/form
     *
     * @return void
     */
    public function new_tutorial_page()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'new_tutorial_page')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!', GTD),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'form' => Templates::get('admin/tutorials/new'),
            ]
        );
        exit;
    }

    /**
     * Create a new tutorial
     *
     * @return void
     */
    public function new_tutorial()
    {
        $file_info = File::get_info(
            $_FILES['file'],
            [
                'dir' => GEOMIFY_TUTORIALS_PATH,
                'url' => GEOMIFY_TUTORIALS_URL,
            ]
        );

        File::move($file_info);

        $insert_id = CRUD::create_from_post(
            'tutorials',
            [
                'uploader_id' => User::current_user_id(),
                'uploaded_at' => $file_info['uploaded_at'],
            ]
        );

        if (is_wp_error($insert_id)) {
            wp_send_json_error(
                [
                    'msg' => __('There was an error adding new tutorial', GTD),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'msg'  => __('New tutorial has been added.', GTD),
                'list' => Templates::get('admin/tutorials/list'),
            ]
        );
        exit;
    }

    /**
     * Get tutorial list for admin
     *
     * @return void
     */
    public function get_admin_tutorials()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'get_admin_tutorials')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!', GTD),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'list' => Templates::get('admin/tutorials/list'),
            ]
        );
        exit;
    }

    /**
     * Delete a tutorial
     *
     * @return void
     */
    public function delete_tutorial()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'delete_tutorial')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!', GTD),
                ]
            );
            exit;
        }

        $tutorial = CRUD::retrieve('tutorials', geomify_var('id'));

        unlink($tutorial->file_path);

        CRUD::delete('tutorials', geomify_var('id'));

        wp_send_json_success(
            [
                'msg' => __('Tutorial deleted!', GTD),
            ]
        );
        exit;
    }

    /**
     * Return tutorials for user dashboard
     *
     * @return void
     */
    public function get_dashboard_tutorial_list()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'get_dashboard_tutorial_list')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!', GTD),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'list' => Templates::get('dashboard/tutorials/list'),
            ]
        );
        exit;
    }

    /**
     * Create a free subscription
     *
     * @return void
     */
    public function create_space()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'create_space')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!', GTD),
                ]
            );
            exit;
        }

        $user_email = geomify_var('email');
        $user_name  = geo_unique_username($user_email);
        $time       = time();

        $userdata = [
            'user_login' => $user_name,
            'user_email' => $user_email,
            'first_name' => geomify_var('first_name'),
            'last_name'  => geomify_var('last_name'),
        ];

        if (email_exists($user_email) && (bool) get_user_meta(get_user_by('email', $user_email)->ID, 'activated', true) === false) {
            User::send_password_reset_link($user_email);
            // wp_delete_user( get_user_by( 'email', $user_email )->ID );
        } else if (email_exists($user_email)) {
            wp_send_json_error(
                [
                    'msg' => __("You've already signed up!", GTD),
                ]
            );
            exit;
        }

        $user_id = wp_insert_user($userdata);

        $activation_id = $user_id . $time * 2;
        $activation_id = str_shuffle($activation_id);

        update_user_meta($user_id, 'activated', false);
        update_user_meta($user_id, 'activation_key', $activation_id);

        geo_session();
        $_SESSION['aurl'] = site_url('/dashboard/activation?action=activate-account&user=' . $user_id . '&key=' . $activation_id);

        // wp_send_json_error( [
        //     // // 'exist' =>wp_delete_user(get_user_by( 'email', $user_email )->ID) ,
        //     // $userdata
        //     // 'exists'=> email_exists( $user_email ) && get_user_meta( get_user_by( 'email', $user_email )->ID, 'activated', true ) === false
        //     // 'exists'=> email_exists( $user_email ) && (bool)get_user_meta( get_user_by( 'email', $user_email )->ID, 'activated', true ) === false
        //     'exists'=>$user_id
        // ] );exit;

        wp_mail(
            $user_email,
            'Account activation email',
            Templates::get('email/header') . Templates::get('email/account-activate') . Templates::get('email/footer'),
            [
                'Content-Type: text/html; charset=UTF-8',
                sprintf('From: %s <admin@geomify.com>', get_bloginfo('name')),
            ]
        );

        // wp_send_json_error( [
        //     // // 'exist' =>wp_delete_user(get_user_by( 'email', $user_email )->ID) ,
        //     // $userdata
        //     // 'exists'=> email_exists( $user_email ) && get_user_meta( get_user_by( 'email', $user_email )->ID, 'activated', true ) === false
        //     'exists'=> email_exists( $user_email ) && (bool)get_user_meta( get_user_by( 'email', $user_email )->ID, 'activated', true ) === false
        // ] );exit;

        wp_send_json_success(
            [
                'page' => Templates::get('user/registration/success1'),
            ]
        );
        exit;
    }

    /**
     * Activate an user from emailed activation link
     *
     * @return void
     */
    public function activate_user_finally()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'activate_user_finally')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!', GTD),
                ]
            );
            exit;
        }

        $password         = geomify_var('password');
        $confirm_password = geomify_var('confirm_password');
        $user_id          = geomify_var('user_id');
        $key              = geomify_var('key');

        if ($password !== $confirm_password) {
            wp_send_json_error(
                [
                    'msg' => __('Password mismatch!', GTD),
                ]
            );
            exit;
        }

        if (get_user_meta($user_id, 'activation_key', true) != $key) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid activation key!', GTD),
                ]
            );
            exit;
        }

        wp_set_password($password, $user_id);

        update_user_meta($user_id, 'activated', true);

        $user_login = get_user_by('ID', $user_id)->user_login;

        $userdata = [
            'user_login'    => $user_login,
            'user_password' => $password,
            'remember'      => true,
        ];

        $success = wp_signon($userdata);

        User::initialize_stripe();

        if (is_wp_error($success)) {
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
    public function get_registration_form()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'get_registration_form')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!', GTD),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'form' => Templates::get('user/registration/step1'),
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
    public function save_ac_info()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'save_ac_info')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!', GTD),
                ]
            );
            exit;
        }

        $info = [
            'first_name',
            'last_name',
            'personal_code',
            'address1',
            'address2',
            'city',
            'company',
            'country',
            'mobile',
            'zip',
            'phone',
            'invoice_email',
            'ean_number',
            'company_number',
            'vat_number',
        ];

        foreach ($info as $single) {
            isset($_POST[$single]) ? User::set_meta($single, $_POST[$single]) : '';
        }

        if (isset($_POST['user_email'])) {
            wp_update_user(
                [
                    'ID'         => User::id(),
                    'user_email' => sanitize_email($_POST['user_email']),
                ]
            );
        }

        if (!empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
            if ($_POST['new_password'] !== $_POST['confirm_password']) {
                wp_send_json_error(
                    [
                        'msg' => __('Password mismatch', GTD),
                    ]
                );
                exit;
            }

            wp_set_password($_POST['new_password'], User::current_user_id());
        }

        if (!empty($_POST['country'])) {
            Gstripe::update_customer(User::stripe_customer_id(), [
                'address' => [
                    'country' => Processor::country_code($_POST['country'])
                ],
                'expand'=>['tax']
            ]);
        }

        if (Processor::is_eu_country(User::get_meta('country'))) {
            Gstripe::update_customer(User::stripe_customer_id(), [
                'tax_exempt' => "reverse"
            ]);
        }

        wp_send_json_success(
            [
                'msg' => __('Settings saved'),
            ]
        );
        exit;
    }

    /**
     * Subscription package update page
     *
     * @return void
     */
    public function upgrade_license_page()
    {

        if (!wp_verify_nonce(geomify_var('nonce'), 'upgrade_license_page')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!', GTD),
                ]
            );
            exit;
        }

        if (User::have_subscription(geomify_var('package_name'))) {
            wp_send_json_error(
                [
                    'msg' => __('You already own this package!', GTD),
                ]
            );
            exit;
        }

        if (User::current_subscription() == 'free' && empty(User::get_meta('country'))) {
            wp_send_json_error(
                [
                    'msg' => __('Please fill up your country name from profile page before start premium subscription.', 'geomify')
                ]
            );
            exit;
        }

        if (!Gstripe::is_current_user_have_pm()) {
            wp_send_json_success(
                [
                    'form' => Templates::get('payment/pay'),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'form' => Templates::get('payment/upgrade'),
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
    public function stripe_payment()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'stripe_payment')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!', GTD),
                ]
            );
            exit;
        }

        $package_name           = geomify_var('package_name');
        $package                = Schema::get('packages')[$package_name];
        $type                   = geomify_var('type');
        $stripe_customer_id     = User::stripe_customer_id();
        $stripe_subscription_id = User::stripe_subscription_id();
        $success                = true;

        if (User::current_subscription() == 'free' && empty(User::get_meta('country'))) {
            wp_send_json_error(
                [
                    'msg' => __('Please fill up your country name from profile page before start premium subscription.', 'geomify')
                ]
            );
            exit;
        }

        switch ($type) {
            case 'card':
                $card_number  = geomify_var('card_number');
                $expire_month = geomify_var('expire_month');
                $expire_year  = geomify_var('expire_year');
                $cvc          = geomify_var('cvc');

                // wp_send_json_error(
                //     [
                //         'msg' => __( 'Your subscription isn\'t active at this moment, try again later or contact support.' ),
                //     ]
                // );exit;

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

                User::set_meta('stripe_payment_method_id', $payment_method_id);

                Gstripe::update_customer(
                    $stripe_customer_id,
                    [
                        'invoice_settings' => [
                            'default_payment_method' => $payment_method_id,
                        ],
                    ]
                );

                $upgraded = User::upgrade_package($package_name);

                if (sizeof((User::pending_invoice_items())) > 0) {
                    $invoice = Gstripe::invoices()->create(
                        [
                            'customer'     => $stripe_customer_id,
                            'subscription' => $stripe_subscription_id,
                        ]
                    );

                    $invoice_id = $invoice->id;

                    if ($invoice->status !== 'paid') {
                        $invoice = Gstripe::invoices()->finalizeInvoice(
                            $invoice_id,
                        );
                    }

                    if ($invoice->status !== 'paid') {
                        $invoice = Gstripe::invoices()->pay(
                            $invoice_id
                        );
                    }

                    if ($package_name === 'facilitator' || $package_name === 'creator') {
                        Gstripe::subscription()->update(
                            User::stripe_subscription_id(),
                            [
                                'pause_collection' => [
                                    'behavior' => 'void',
                                ],
                            ]
                        );
                        Processor::send_manual_license_email();
                    }
                } else {
                    $invoice = Gstripe::invoices()->retrieve($upgraded->latest_invoice);
                }

                geo_session();

                $_SESSION['latest_stripe_invoice'] = $invoice;

                break;
            default:
                break;
        }

        if ($success) {
            wp_send_json_success(
                [
                    'page' => Templates::get('payment/upgrade_success'),
                ]
            );
            exit;
        }

        wp_send_json_error(
            [
                'msg' => __('There was an error upgrading your package, try again please', GTD),
            ]
        );
        exit;
    }

    /**
     * Upgrade subscription package through ajax
     *
     * @return void
     */
    public function stripe_upgrade()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'stripe_upgrade')) {
            wp_send_json_error(
                [
                    'msg' => __('Invlaid token!', GTD),
                ]
            );
            exit;
        }

        if (!Gstripe::is_current_user_have_pm()) {
            wp_send_json_error(
                [
                    'msg' => __('You don\'nt have any payment method!', GTD),
                ]
            );
            exit;
        }

        if (!User::is_sub_active()) {
            wp_send_json_error(
                [
                    'msg' => __('Your subscription isn\'t active at this moment, try again later or contact support.'),
                ]
            );
            exit;
        }

        geo_session();
        $package_name             = geomify_var('package_name');
        $package                  = Schema::get('packages')[$package_name];
        $stripe_customer_id       = User::get_meta('stripe_customer_id');
        $stripe_subscription_id   = User::get_meta('stripe_subscription_id');
        $_SESSION['package_name'] = $package_name;

        if (User::current_subscription() == 'free' && empty(User::get_meta('country'))) {
            wp_send_json_error(
                [
                    'msg' => __('Please fill up your country name from profile page before start premium subscription.', 'geomify')
                ]
            );
            exit;
        }


        if (User::have_subscription($package_name)) {
            wp_send_json_error(
                [
                    'msg' => __('You already own this package!', GTD),
                ]
            );
            exit;
        }

        $upgraded = User::upgrade_package($package_name);

        if (sizeof((User::pending_invoice_items())) > 0) {
            $invoice = Gstripe::invoices()->create(
                [
                    'customer'     => $stripe_customer_id,
                    'subscription' => $stripe_subscription_id,
                ]
            );

            $invoice_id = $invoice->id;

            if ($invoice->status !== 'paid') {
                $invoice = Gstripe::invoices()->finalizeInvoice(
                    $invoice_id,
                );
            }

            if ($invoice->status !== 'paid') {
                $invoice = Gstripe::invoices()->pay(
                    $invoice_id
                );
            }
            if ($package_name === 'facilitator' || $package_name === 'creator') {
                Gstripe::subscription()->update(
                    User::stripe_subscription_id(),
                    [
                        'pause_collection' => [
                            'behavior' => 'void',
                        ],
                    ]
                );
                Processor::send_manual_license_email();
            }
        } else {
            $invoice = Gstripe::invoices()->retrieve($upgraded->latest_invoice);
        }

        $_SESSION['latest_stripe_invoice'] = $invoice;

        wp_send_json_success(
            [
                'page' => Templates::get('payment/upgrade_success'),
            ]
        );
        exit;
    }

    /**
     * Enterprise quote submission
     *
     * @return void
     */
    public function submit_enterprise_quote()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'submit_enterprise_quote')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!'),
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

        if (is_wp_error($inserted)) {
            wp_send_json_error(
                [
                    'msg' => $inserted->get_error_message(),
                ]
            );
            exit;
        }

        wp_mail(
            'license@geomify.com',
            'Enterprise quote',
            Templates::get('email/header') . Templates::get('email/enterprise-quote'),
            [
                'Content-Type: text/html; charset=UTF-8',
                sprintf('From: %s <admin@geomify.com>', get_bloginfo('name')),
            ]
        );

        wp_send_json_success(
            [
                'page' => Templates::get('enterprise/quote-success'),
            ]
        );
        exit;
    }

    /**
     * Partner programs request submission
     *
     * @return void
     */
    public function partner_programs_request_submit()
    {

        if (!wp_verify_nonce(geomify_var('nonce'), 'partner_programs_request_submit')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!'),
                ]
            );
            exit;
        }

        extract($_POST);

        $inserted = CRUD::create_from_post(
            'partner_programs_request',
            [
                'time' => time(),
            ]
        );

        if (is_wp_error($inserted)) {
            wp_send_json_error(
                [
                    'msg' => $inserted->get_error_message(),
                ]
            );
            exit;
        }

        wp_mail(
            'partner@geomify.com',
            'Partner programs',
            Templates::get('email/header') . Templates::get('email/partner-programs') . Templates::get('email/footer'),
            [
                'Content-Type: text/html; charset=UTF-8',
                sprintf('From: %s <admin@geomify.com>', get_bloginfo('name')),
            ]
        );

        wp_send_json_success(
            [
                'template' => do_shortcode($shortcode),
            ]
        );
        exit;
    }

    /**
     * Educational institues apply submission
     *
     * @return void
     */
    public function educational_institues_apply_submit()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'educational_institues_apply_submit')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!'),
                ]
            );
            exit;
        }

        extract($_POST);

        $inserted = CRUD::create_from_post(
            'educational_institutes_requests',
            [
                'time' => time(),
            ]
        );

        if (is_wp_error(($inserted))) {
            wp_send_json_error(
                [
                    'msg' => $inserted->get_error_message(),
                ]
            );
            exit;
        }

        geo_mail('education@geomify.com', 'Educational License', 'education-apply');

        wp_send_json_success(
            [
                'template' => do_shortcode($shortcode),
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
    public function file_info_submit()
    {
        if (wp_verify_nonce(geomify_var('nonce'), 'file_info_submit_nonce')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!'),
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

        if (is_wp_error($inserted)) {
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
                'msg' => __('File submission created'),
            ]
        );
        exit;
    }

    /**
     * User file upload management
     *
     * @return void
     */
    public function upload_geo_files()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'upload_geo_files') || !isset($_SESSION['file_info_id'])) {
            wp_send_json_error(

                [
                    'a'   => isset($_SESSION['file_info_id']),
                    'b'   => wp_verify_nonce(geomify_var('nonce'), 'upload_geo_files'),
                    'msg' => __('Invalid token!'),
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
                'file_info'   => serialize($file_info),
                'uploaded_at' => time(),
                'geo_id'      => $_SESSION['file_info_id'],
            ]
        );

        if (is_wp_error($inserted)) {
            wp_send_json_error(
                [
                    'msg' => $inserted->get_error_message(),
                ]
            );
            exit;
        }

        $sc = move_uploaded_file($file_info['tmp_name'], $file_info['dir']);

        wp_send_json_success(
            [
                'msg' => __('File uploaded'),
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
    public function remove_pm()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'remove_pm')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!'),
                ]
            );
            exit;
        }

        Gstripe::detach_payment_method($_POST['id']);

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
    public function dlt_pv()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'dlt_pv')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token'),
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
                'msg' => __('Project view deleted'),
            ]
        );
        exit;
    }

    /**
     * Edit project view form
     *
     * @return void
     */
    public function edit_pv_form()
    {
        wp_send_json_success(
            [
                'form' => Templates::get('dashboard/project-views/edit'),
            ]
        );
        exit;
    }

    /**
     * Update edited project view
     *
     * @return void
     */
    public function update_pv()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'update_pv')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!'),
                ]
            );
            exit;
        }

        $updated = CRUD::update_from_post('project_views', isset($_POST['id']) ? $_POST['id'] : 0);

        if (is_wp_error($updated)) {
            wp_send_json_error(
                [
                    'msg' => $updated->get_error_message(),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'msg' => __('Project view updated'),
            ]
        );
        exit;
    }

    public function start_basic_form()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'start_basic_form')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!'),
                ]
            );
            exit;
        }

        $package_name = geomify_var('package_name');

        if (User::is_logged() && geomify_var('package_name') == User::current_subscription()) {
            wp_send_json_error(
                [
                    'msg' => __('You already subscribed to this package'),
                ]
            );
            exit;
        }

        // For logged in user
        if (User::is_logged()) {
            if (User::have_subscription($package_name)) {
                wp_send_json_error(
                    [
                        'msg' => 'You\'ve already subscribed to ' . $package_name,
                    ]
                );
                exit;
            }
            // If user haven't payment method added
            if (!Gstripe::is_current_user_have_pm()) {
                wp_send_json_success(
                    [
                        'form' => Templates::get('payment/pay'),
                    ]
                );
                exit;
            }

            // If user have payment method added
            wp_send_json_success(
                [
                    'form' => Templates::get('payment/upgrade'),
                ]
            );
            exit;
        }

        // If user isn't logged in

        wp_send_json_success(
            [
                'form' => Templates::get('payment/start-basic'),
            ]
        );
        exit;
    }

    public function start_basic()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'start_basic')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!'),
                ]
            );
            exit;
        }
        extract($_POST);

        $package_name = isset($_POST['package_name']) ? $_POST['package_name'] : 'free';
        $user_name    = geo_unique_username($email);
        $time         = time();

        $userdata = [
            'user_login' => $user_name,
            'user_email' => $email,
            'first_name' => $first_name,
            'last_name'  => $last_name,
        ];

        if (email_exists($email)) {
            wp_send_json_error(
                [
                    'msg' => __("You've already signed up!", GTD),
                ]
            );
            exit;
        }

        $user_id = wp_insert_user($userdata);

        $activation_id = $user_id . $time * 2;
        $activation_id = str_shuffle($activation_id);

        update_user_meta($user_id, 'activated', false);
        update_user_meta($user_id, 'activation_key', $activation_id);

        $stripe_customer_id = Gstripe::create_customer(
            [
                'email'       => $userdata['user_email'],
                'description' => 'Subscriber',
                'name'        => $userdata['first_name'] . ' ' . $userdata['last_name'],
            ]
        )->id;

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

        Gstripe::attach_payment_method($payment_method_id, $stripe_customer_id);

        Gstripe::update_customer(
            $stripe_customer_id,
            [
                'invoice_settings' => [
                    'default_payment_method' => $payment_method_id,
                ],
            ]
        );

        $stripe_subscription_id = Gstripe::create_subscription($stripe_customer_id, Gstripe::package(isset($_POST['package_name']) ? $_POST['package_name'] : 'free'))->id;

        update_user_meta($user_id, 'stripe_customer_id', $stripe_customer_id);
        update_user_meta($user_id, 'stripe_subscription_id', $stripe_subscription_id);
        update_user_meta($user_id, 'stripe_payment_method_id', $payment_method_id);

        if ($package_name === 'facilitator' || $package_name === 'creator') {
            Gstripe::subscription()->update(
                User::stripe_subscription_id(),
                [
                    'pause_collection' => [
                        'behavior' => 'void',
                    ],
                ]
            );
            Processor::send_manual_license_email();
        }

        geo_session();
        $_SESSION['aurl'] = site_url('/dashboard/activation?action=activate-account&user=' . $user_id . '&key=' . $activation_id);

        wp_mail(
            $email,
            'Account activation email',
            Templates::get('email/header') . Templates::get('email/account-activate-basic') . Templates::get('email/footer'),
            [
                'Content-Type: text/html; charset=UTF-8',
                sprintf('From: %s <admin@geomify.com>', get_bloginfo('name')),
            ]
        );

        wp_send_json_success(
            [
                'page' => Templates::get('payment/start-basic-success'),
            ]
        );
    }

    public function geo_login()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'geo_login')) {
            wp_send_json_error(
                [
                    wp_verify_nonce(geomify_var('nonce'), 'geo_login'),
                    $_POST,
                    'msg' => __('Invalid token!'),
                ]
            );
            exit;
        }

        extract($_POST);

        // Email login
        if (filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            if (!email_exists($user_email)) {
                wp_send_json_error(
                    [
                        'msg' => __('Account not found!'),
                    ]
                );
                exit;
            }

            $user = get_user_by('email', $user_email);
            // Username login
        } else {
            $user = get_user_by('login', $user_email);

            if (!$user) {
                wp_send_json_error(
                    [
                        'msg' => __('Account not found!'),
                    ]
                );
                exit;
            }
        }

        if (!wp_check_password($password, $user->user_pass)) {
            wp_send_json_error(
                [
                    'pass' => $user_email,
                    'msg'  => __('Incorrect password!'),
                ]
            );
            exit;
        }

        $userdata = [
            'user_login'    => $user_email,
            'user_password' => $password,
            'remember'      => true,
        ];

        $islogged = wp_signon($userdata);

        if (!$islogged) {
            wp_send_json_error(
                [
                    'msg' => __('There was an problem with this credential. Try again please.'),
                ]
            );
            exit;
        }

        do_action('geo_login', $userdata, $islogged);

        wp_send_json_success(
            [
                'msg' => __('Login success, redirecting...'),
            ]
        );
        exit;
    }

    public function geo_reset()
    {
        // if ( ! wp_verify_nonce( geomify_var( 'nonce' ), 'geo_reset' ) ) {
        //     wp_send_json_error(
        //         [
        //             'msg' => __( 'Invalid token!' ),
        //         ]
        //     );
        //     exit;
        // }

        extract($_POST);

        // If email
        if (filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            if (!email_exists($user_email)) {
                wp_send_json_error(
                    [
                        'msg' => __('Account not found!'),
                    ]
                );
                exit;
            }

            $user = get_user_by('email', $user_email);

            // If username
        } else {
            $user = get_user_by('login', $user_email);

            if (!$user) {
                wp_send_json_error(
                    [
                        'msg' => __('Account not found!'),
                    ]
                );
                exit;
            }
        }

        $_SESSION['geo_reset_user'] = $user->ID;

        // User found, send reset link
        geo_mail(
            $user->user_email,
            'Password reset link',
            'password_reset',
            'reset-header',
            'reset-footer'
        );
        // wp_send_json_error( $user->user_email );exit;

        wp_send_json_success(
            [
                'msg' => __('Check your email for password reset link'),
            ]
        );
        exit;
    }

    public function geo_pass_reset()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'geo_pass_reset')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!'),
                    // 'msg' => geomify_var('nonce'),
                ]
            );
            exit;
        }

        extract($_POST);

        $real_token      = get_user_meta($user, 'geo_reset_code', true);
        $session_started = get_user_meta($user, 'geo_reset_start', true);
        $current_time    = time();

        if (empty(geomify_var('u_token'))) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!'),
                ]
            );
            exit;
        }

        if ($session_started - $current_time > 21600000) {
            wp_send_json_error(
                [
                    'msg' => __('Token expired!'),
                ]
            );
            exit;
        }

        if ($token !== $real_token) {
            wp_send_json_error(
                [
                    'msg' => __('Token mismatch!'),
                ]
            );
            exit;
        }

        if ($password !== $confirm_password) {
            wp_send_json_error(
                [
                    'msg' => __('Password mismatch'),
                ]
            );
            exit;
        }

        wp_set_password($password, $user);

        $userdata = [
            'user_login'    => get_userdata($user)->user_login,
            'user_password' => $password,
            'remember'      => true,
        ];

        $islogged = wp_signon($userdata);

        update_user_meta($user, 'geo_reset_code', '');
        update_user_meta($user, 'geo_reset_start', '');

        wp_send_json_success(
            [
                'msg' => __('Password changed!'),
            ]
        );
        exit;
    }

    public function save_geo_options()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'save_geo_options')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!'),
                ]
            );
            exit;
        }

        $list = [
            'stripe_api_key',
            'stripe_secret_key',
            'free_subscription_key',
            'basic_subscription_key',
            'facilitator_subscription_key',
            'creator_subscription_key',
            'enterprise_subscription_key',
        ];

        foreach ($list as $item) {
            if (!isset($_POST[$item])) {
                continue;
            }

            update_option($item, geomify_var($item));
        }

        wp_send_json_success(
            [
                'msg' => __("Settings  saved"),
            ]
        );
        exit;
    }

    public function dlt_geo_file()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'dlt_geo_file')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!'),
                ]
            );
            exit;
        }

        $id = isset($_POST['id']) ? $_POST['id'] : 0;

        $files = CRUD::retrieve('geo_files', $id, 'geo_id');

        foreach ($files as $file) {
            unlink($file->file_path);
        }

        CRUD::delete('geo_files_info', $id);
        CRUD::delete('geo_files', $id, 'geo_id');

        wp_send_json_success(
            [
                'msg' => __('File deleted'),
            ]
        );
        exit;
    }

    public function view_geo_file()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'view_geo_file')) {
            wp_send_json_error(
                [
                    'msg' => __('Invalid token!'),
                ]
            );
            exit;
        }

        wp_send_json_success(
            [
                'view' => Templates::get('admin/geo-files/view'),
            ]
        );
        exit;
    }

    public function geo_admin_login()
    {
        if (!wp_verify_nonce(geomify_var('nonce'), 'geo_admin_login')) {
            wp_send_json_error(
                [
                    $_POST,
                    'msg' => __('Invalid token!'),
                ]
            );
            exit;
        }

        extract($_POST);

        // Email login
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if (!email_exists($email)) {
                wp_send_json_error(
                    [
                        'msg' => __('Account not found!'),
                    ]
                );
                exit;
            }

            $user = get_user_by('email', $email);
            // Username login
        } else {
            $user = get_user_by('login', $email);

            if (!$user) {
                wp_send_json_error(
                    [
                        'msg' => __('Account not found!'),
                    ]
                );
                exit;
            }
        }


        if (!in_array('administrator', $user->roles)) {
            wp_send_json_error(
                [
                    'msg' => __('This is not an admin account!'),
                ]
            );
            exit;
        }


        if (!wp_check_password($password, $user->user_pass)) {
            wp_send_json_error(
                [
                    'pass' => $email,
                    'msg'  => __('Incorrect password!'),
                ]
            );
            exit;
        }



        $userdata = [
            'user_login'    => $email,
            'user_password' => $password,
            'remember'      => true,
        ];

        if (!wp_signon($userdata)) {
            wp_send_json_error(
                [
                    'msg' => __('There was an problem with this credential. Try again please.'),
                ]
            );
            exit;
        }

        do_action('geo_login', $userdata, $user);

        // wp_send_json_error($email);

        wp_send_json_success(
            [
                'msg'      => __('Login success, redirecting...'),
                'is_admin' => in_array('administrator', $user->roles),
            ]
        );
        exit;
    }
}
