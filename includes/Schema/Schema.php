<?php

namespace geomify\Schema;

defined( 'ABSPATH' ) or exit;

use \geomify\Processor\Processor as Processor;

class Schema {

    public function __construct() {
        $this->build();
    }

    /**
     * Build the schema
     *
     * @return void
     */
    public function build() {
        $domain = 'geomify';

        $this->schema = [
            'settings'      => [
                'style' => [
                    'primary-color'   => [
                        'label' => __( 'Primary color', $domain ),
                        'value' => '',
                        'type'  => 'color',
                    ],
                    'secondary-color' => [
                        'label' => __( 'Secondary color', $domain ),
                        'value' => '',
                        'type'  => 'color',
                    ],
                    'transition'      => [
                        'label' => __( 'Transition', $domain ),
                        'value' => 'all .3s ease-in-out',
                        'type'  => 'text',
                    ],
                ],
            ],
            'site_settings' => [
                'enable-jump-top' => [
                    'label' => __( 'Enable jump to top', $domain ),
                    'type'  => 'radio',
                    'value' => 'enabled',
                ],
            ],
        ];

        $this->schema['allowed_shortcodes'] = [
            '[contact-form-7 id="593" title="Plant & Process"]',
            '[contact-form-7 id="735" title="Contact us"]',
            '[elementor-template id="2305"]',
        ];

        $this->schema['educational_institutes_requests'] = [
            'educational_institue' => [
                'label'    => __( 'Educational institue', $domain ),
                'required' => true,
            ],
            'location'             => [
                'label'    => __( 'Location', $domain ),
                'type'     => 'select',
                'options'  => Processor::txtfile2array( GEOMIFY_RESOURCE_PATH . 'countries.txt' ),
                'required' => true,
            ],
            'street_address'       => [
                'label'    => __( 'Street address', $domain ),
                'required' => true,
            ],
            'zip_code'             => [
                'label'    => __( 'Zip code', $domain ),
                'required' => true,
            ],
            'city'                 => [
                'label'    => __( 'City', $domain ),
                'required' => true,
            ],
            'contact_first'        => [
                'label'       => __( 'Institution Contact', $domain ),
                'placeholder' => __( 'First', $domain ),
                'required'    => true,
            ],
            'contact_last'         => [
                'label'       => __( 'Last', $domain ),
                'placeholder' => __( 'Last', $domain ),
                'required'    => true,
            ],
            'email'                => [
                'label'       => __( 'Email', $domain ),
                'placeholder' => __( 'Institution email', $domain ),
                'required'    => true,
            ],
            'mobile'               => [
                'label'       => __( 'Mobile phone', $domain ),
                'placeholder' => __( 'Country code + mobile or direct number', $domain ),
                'required'    => true,
            ],
            'time'                 => [
                'label'    => __( 'Time' ),
                'required' => true,
            ],
        ];

        $this->schema['project_views'] = [
            'project_view_name' => [
                'label'       => __( 'Project View Nmae', $domain ),
                'placeholder' => __( 'Project View', $domain ),
            ],
            'description'       => [
                'label'       => __( 'Project view description' ),
                'placeholder' => __( 'Project view description' ),
            ],
            'url'               => [
                'label'       => __( 'URL', $domain ),
                'placeholder' => __( 'URL', $domain ),
                'type'        => 'url',
            ],
            'industry'          => [
                'label'       => __( 'Industry', $domain ),
                'placeholder' => __( '- Select Industry -', $domain ),
                'type'        => 'select',
                'options'     => [
                    'a' => 'a',
                ],
            ],
            'country'           => [
                'label'       => __( 'Country', $domain ),
                'placeholder' => __( '- Select Country -', $domain ),
                'type'        => 'select',
                'options'     => Processor::txtfile2array( GEOMIFY_RESOURCE_PATH . 'countries.txt' ),
            ],
            'user_id'           => [
                'label'       => __( 'User ID', $domain ),
                'placeholder' => __( '00563', $domain ),
                'type'        => 'number',
                'data_type'   => 'bigint',
                'hidden'      => true,
            ],
        ];

        // Profile schema
        // Basic
        $this->schema['profile_basic'] = [
            'user_email'     => [
                'label'       => __( 'User email', $domain ),
                'placeholder' => __( 'User email', $domain ),
                'type'        => 'email',
            ],
            'personal_code'  => [
                'label'       => __( 'Personal code', $domain ),
                'placeholder' => __( 'Personal code', $domain ),
            ],
            'password'       => [
                'label'       => __( 'Password', $domain ),
                'placeholder' => __( 'Password', $domain ),
                'type'        => 'password',
            ],
            'first_name'     => [
                'label'       => __( 'First name', $domain ),
                'placeholder' => __( 'First name', $domain ),
            ],
            'last_name'      => [
                'label'       => __( 'Last name', $domain ),
                'placeholder' => __( 'Last name', $domain ),
            ],
            'mobile'         => [
                'label'       => __( 'Mobile', $domain ),
                'placeholder' => __( 'Mobile (i.e +45 number', $domain ),
            ],
            'phone'          => [
                'label'       => __( 'Phone', $domain ),
                'placeholder' => __( 'Mobile (i.e +45 number', $domain ),
            ],
            'company'        => [
                'label'       => __( 'Company/Organization', $domain ),
                'placeholder' => __( 'Company/Organization', $domain ),
            ],
            'address1'       => [
                'label'       => __( 'Address', $domain ),
                'placeholder' => __( 'Address', $domain ),
            ],
            'address2'       => [
                'label'       => __( 'Address', $domain ),
                'placeholder' => __( 'Address', $domain ),
            ],
            'zip'            => [
                'label'       => __( 'Zip', $domain ),
                'placeholder' => __( 'Zip', $domain ),
            ],
            'city'           => [
                'label'       => __( 'City', $domain ),
                'placeholder' => __( 'City', $domain ),
            ],
            'country'        => [
                'label'       => __( 'Country', $domain ),
                'placeholder' => __( '- Select country -', $domain ),
                'type'        => 'select',
                'options'     => Processor::txtfile2array( GEOMIFY_RESOURCE_PATH . 'countries.txt' ),
            ],
            'vat_number'     => [
                'label'       => __( 'VAT number', $domain ),
                'placeholder' => __( 'VAT number', $domain ),
            ],
            'ean_number'     => [
                'label'       => __( 'EAN number', $domain ),
                'placeholder' => __( 'EAN number', $domain ),
            ],
            'company_number' => [
                'label'       => __( 'Comapny number', $domain ),
                'placeholder' => __( 'Comapny number', $domain ),
            ],
            'invoice_email'  => [
                'label'       => __( 'Invoice email', $domain ),
                'placeholder' => __( 'Invoice email', $domain ),
                'type'        => 'email',
            ],
        ];

        $this->schema['profile_free'] = [
            'user_email'     => [
                'label'       => __( 'User email', $domain ),
                'placeholder' => __( 'User email', $domain ),
                'type'        => 'email',
            ],
            'personal_code'  => [
                'label'       => __( 'Personal code', $domain ),
                'placeholder' => __( 'Personal code', $domain ),
            ],
            'password'       => [
                'label'       => __( 'Password', $domain ),
                'placeholder' => __( 'Password', $domain ),
                'type'        => 'password',
            ],
            'first_name'     => [
                'label'       => __( 'First name', $domain ),
                'placeholder' => __( 'First name', $domain ),
            ],
            'last_name'      => [
                'label'       => __( 'Last name', $domain ),
                'placeholder' => __( 'Last name', $domain ),
            ],
            'mobile'         => [
                'label'       => __( 'Mobile', $domain ),
                'placeholder' => __( 'Mobile (i.e +45 number', $domain ),
            ],
            'phone'          => [
                'label'       => __( 'Phone', $domain ),
                'placeholder' => __( 'Mobile (i.e +45 number', $domain ),
            ],
            'company'        => [
                'label'       => __( 'Company/Organization', $domain ),
                'placeholder' => __( 'Company/Organization', $domain ),
            ],
            'address1'       => [
                'label'       => __( 'Address', $domain ),
                'placeholder' => __( 'Address', $domain ),
            ],
            'address2'       => [
                'label'       => __( 'Address', $domain ),
                'placeholder' => __( 'Address', $domain ),
            ],
            'zip'            => [
                'label'       => __( 'Zip', $domain ),
                'placeholder' => __( 'Zip', $domain ),
            ],
            'city'           => [
                'label'       => __( 'City', $domain ),
                'placeholder' => __( 'City', $domain ),
            ],
            'country'        => [
                'label'       => __( 'Country', $domain ),
                'placeholder' => __( '- Select country -', $domain ),
                'type'        => 'select',
                'options'     => Processor::txtfile2array( GEOMIFY_RESOURCE_PATH . 'countries.txt' ),
            ],
            'vat_number'     => [
                'label'       => __( 'VAT number', $domain ),
                'placeholder' => __( 'VAT number', $domain ),
            ],
            'ean_number'     => [
                'label'       => __( 'EAN number', $domain ),
                'placeholder' => __( 'EAN number', $domain ),
            ],
            'company_number' => [
                'label'       => __( 'Comapny number', $domain ),
                'placeholder' => __( 'Comapny number', $domain ),
            ],
            'invoice_email'  => [
                'label'       => __( 'Invoice email', $domain ),
                'placeholder' => __( 'Invoice email', $domain ),
                'type'        => 'email',
            ],
        ];

        $this->schema['profile_facilitator'] = [
            'user_email'     => [
                'label'       => __( 'User email', $domain ),
                'placeholder' => __( 'User email', $domain ),
                'type'        => 'email',
            ],
            'personal_code'  => [
                'label'       => __( 'Personal code', $domain ),
                'placeholder' => __( 'Personal code', $domain ),
            ],
            'password'       => [
                'label'       => __( 'Password', $domain ),
                'placeholder' => __( 'Password', $domain ),
                'type'        => 'password',
            ],
            'first_name'     => [
                'label'       => __( 'First name', $domain ),
                'placeholder' => __( 'First name', $domain ),
            ],
            'last_name'      => [
                'label'       => __( 'Last name', $domain ),
                'placeholder' => __( 'Last name', $domain ),
            ],
            'mobile'         => [
                'label'       => __( 'Mobile', $domain ),
                'placeholder' => __( 'Mobile (i.e +45 number', $domain ),
            ],
            'phone'          => [
                'label'       => __( 'Phone', $domain ),
                'placeholder' => __( 'Mobile (i.e +45 number', $domain ),
            ],
            'company'        => [
                'label'       => __( 'Company/Organization', $domain ),
                'placeholder' => __( 'Company/Organization', $domain ),
            ],
            'address1'       => [
                'label'       => __( 'Address', $domain ),
                'placeholder' => __( 'Address', $domain ),
            ],
            'address2'       => [
                'label'       => __( 'Address', $domain ),
                'placeholder' => __( 'Address', $domain ),
            ],
            'zip'            => [
                'label'       => __( 'Zip', $domain ),
                'placeholder' => __( 'Zip', $domain ),
            ],
            'city'           => [
                'label'       => __( 'City', $domain ),
                'placeholder' => __( 'City', $domain ),
            ],
            'country'        => [
                'label'       => __( 'Country', $domain ),
                'placeholder' => __( '- Select country -', $domain ),
                'type'        => 'select',
                'options'     => Processor::txtfile2array( GEOMIFY_RESOURCE_PATH . 'countries.txt' ),
            ],
            'vat_number'     => [
                'label'       => __( 'VAT number', $domain ),
                'placeholder' => __( 'VAT number', $domain ),
            ],
            'ean_number'     => [
                'label'       => __( 'EAN number', $domain ),
                'placeholder' => __( 'EAN number', $domain ),
            ],
            'company_number' => [
                'label'       => __( 'Comapny number', $domain ),
                'placeholder' => __( 'Comapny number', $domain ),
            ],
            'invoice_email'  => [
                'label'       => __( 'Invoice email', $domain ),
                'placeholder' => __( 'Invoice email', $domain ),
                'type'        => 'email',
            ],
        ];

        $this->schema['profile_creator'] = [
            'user_email'     => [
                'label'       => __( 'User email', $domain ),
                'placeholder' => __( 'User email', $domain ),
                'type'        => 'email',
            ],
            'personal_code'  => [
                'label'       => __( 'Personal code', $domain ),
                'placeholder' => __( 'Personal code', $domain ),
            ],
            'password'       => [
                'label'       => __( 'Password', $domain ),
                'placeholder' => __( 'Password', $domain ),
                'type'        => 'password',
            ],
            'first_name'     => [
                'label'       => __( 'First name', $domain ),
                'placeholder' => __( 'First name', $domain ),
            ],
            'last_name'      => [
                'label'       => __( 'Last name', $domain ),
                'placeholder' => __( 'Last name', $domain ),
            ],
            'mobile'         => [
                'label'       => __( 'Mobile', $domain ),
                'placeholder' => __( 'Mobile (i.e +45 number', $domain ),
            ],
            'phone'          => [
                'label'       => __( 'Phone', $domain ),
                'placeholder' => __( 'Mobile (i.e +45 number', $domain ),
            ],
            'company'        => [
                'label'       => __( 'Company/Organization', $domain ),
                'placeholder' => __( 'Company/Organization', $domain ),
            ],
            'address1'       => [
                'label'       => __( 'Address', $domain ),
                'placeholder' => __( 'Address', $domain ),
            ],
            'address2'       => [
                'label'       => __( 'Address', $domain ),
                'placeholder' => __( 'Address', $domain ),
            ],
            'zip'            => [
                'label'       => __( 'Zip', $domain ),
                'placeholder' => __( 'Zip', $domain ),
            ],
            'city'           => [
                'label'       => __( 'City', $domain ),
                'placeholder' => __( 'City', $domain ),
            ],
            'country'        => [
                'label'       => __( 'Country', $domain ),
                'placeholder' => __( '- Select country -', $domain ),
                'type'        => 'select',
                'options'     => Processor::txtfile2array( GEOMIFY_RESOURCE_PATH . 'countries.txt' ),
            ],
            'vat_number'     => [
                'label'       => __( 'VAT number', $domain ),
                'placeholder' => __( 'VAT number', $domain ),
            ],
            'ean_number'     => [
                'label'       => __( 'EAN number', $domain ),
                'placeholder' => __( 'EAN number', $domain ),
            ],
            'company_number' => [
                'label'       => __( 'Comapny number', $domain ),
                'placeholder' => __( 'Comapny number', $domain ),
            ],
            'invoice_email'  => [
                'label'       => __( 'Invoice email', $domain ),
                'placeholder' => __( 'Invoice email', $domain ),
                'type'        => 'email',
            ],
        ];

        $this->schema['profile_enterprise'] = [
            'user_email'     => [
                'label'       => __( 'User email', $domain ),
                'placeholder' => __( 'User email', $domain ),
                'type'        => 'email',
            ],
            'personal_code'  => [
                'label'       => __( 'Personal code', $domain ),
                'placeholder' => __( 'Personal code', $domain ),
            ],
            'password'       => [
                'label'       => __( 'Password', $domain ),
                'placeholder' => __( 'Password', $domain ),
                'type'        => 'password',
            ],
            'first_name'     => [
                'label'       => __( 'First name', $domain ),
                'placeholder' => __( 'First name', $domain ),
            ],
            'last_name'      => [
                'label'       => __( 'Last name', $domain ),
                'placeholder' => __( 'Last name', $domain ),
            ],
            'mobile'         => [
                'label'       => __( 'Mobile', $domain ),
                'placeholder' => __( 'Mobile (i.e +45 number', $domain ),
            ],
            'phone'          => [
                'label'       => __( 'Phone', $domain ),
                'placeholder' => __( 'Mobile (i.e +45 number', $domain ),
            ],
            'company'        => [
                'label'       => __( 'Company/Organization', $domain ),
                'placeholder' => __( 'Company/Organization', $domain ),
            ],
            'address1'       => [
                'label'       => __( 'Address', $domain ),
                'placeholder' => __( 'Address', $domain ),
            ],
            'address2'       => [
                'label'       => __( 'Address', $domain ),
                'placeholder' => __( 'Address', $domain ),
            ],
            'zip'            => [
                'label'       => __( 'Zip', $domain ),
                'placeholder' => __( 'Zip', $domain ),
            ],
            'city'           => [
                'label'       => __( 'City', $domain ),
                'placeholder' => __( 'City', $domain ),
            ],
            'country'        => [
                'label'       => __( 'Country', $domain ),
                'placeholder' => __( '- Select country -', $domain ),
                'type'        => 'select',
                'options'     => Processor::txtfile2array( GEOMIFY_RESOURCE_PATH . 'countries.txt' ),
            ],
            'vat_number'     => [
                'label'       => __( 'VAT number', $domain ),
                'placeholder' => __( 'VAT number', $domain ),
            ],
            'ean_number'     => [
                'label'       => __( 'EAN number', $domain ),
                'placeholder' => __( 'EAN number', $domain ),
            ],
            'company_number' => [
                'label'       => __( 'Comapny number', $domain ),
                'placeholder' => __( 'Comapny number', $domain ),
            ],
            'invoice_email'  => [
                'label'       => __( 'Invoice email', $domain ),
                'placeholder' => __( 'Invoice email', $domain ),
                'type'        => 'email',
            ],
        ];

        $this->schema['tutorials'] = [
            'caption'     => [
                'label'       => __( 'Caption', $domain ),
                'placeholder' => __( 'Caption', $domain ),
                'use_label'   => true,
                'required'    => true,
            ],
            'license'     => [
                'label'       => __( 'License', $domain ),
                'placeholder' => __( 'License', $domain ),
                'type'        => 'select',
                'options'     => [
                    'Free'        => __( 'Free', $domain ),
                    'Basic'       => __( 'Basic', $domain ),
                    'Facilitator' => __( 'Facilitator', $domain ),
                    'Creator'     => __( 'Creator', $domain ),
                    'Enterprise'  => __( 'Enterprise', $domain ),
                ],
                'use_label'   => true,
                'required'    => true,
            ],
            'file_url'    => [
                'label'       => __( 'File URL', $domain ),
                'placeholder' => __( 'File URL', $domain ),
            ],
            'file_path'   => [
                'label'       => __( 'File path', $domain ),
                'placeholder' => __( 'File path', $domain ),
            ],
            'file_info'   => [

            ],
            'uploader_id' => [

            ],
            'uploaded_at' => [

            ],
        ];

        $this->schema['packages'] = [
            'free'        => [
                'label'       => __( 'Free', $domain ),
                'placeholder' => __( 'Free', $domain ),
                'price'       => 0,
                'currency'    => 'eur',
            ],
            'basic'       => [
                'label'       => __( 'Basic', $domain ),
                'placeholder' => __( 'Basic', $domain ),
                'price'       => 108,
                'currency'    => 'eur',
            ],
            'facilitator' => [
                'label'       => __( 'Facilitator', $domain ),
                'placeholder' => __( 'Faclitator', $domain ),
                'price'       => 828,
                'currency'    => 'eur',
            ],
            'creator'     => [
                'label'       => __( 'Creator', $domain ),
                'placeholder' => __( 'Creator', $domain ),
                'price'       => 2028,
                'currency'    => 'eur',
            ],
            'enterprise'  => [
                'label'       => __( 'Enterprise', $domain ),
                'placeholder' => __( 'Enterprise', $domain ),
                'currency'    => 'eur',
            ],
        ];

        $this->schema['registration'] = [
            'email'            => [
                'placeholder' => __( 'Email address', $domain ),
                'type'        => 'email',
                'required'    => true,
            ],
            'first_name'       => [
                'placeholder' => __( 'First name', $domain ),
                'required'    => true,
            ],
            'last_name'        => [
                'placeholder' => __( 'Last name', $domain ),
                'required'    => true,
            ],
            'password'         => [
                'placeholder' => __( 'Password', $domain ),
                'type'        => 'password',
                'required'    => true,
                'class'       => ['show-hide-password'],
            ],
            'confirm_password' => [
                'placeholder' => __( 'Confirm password', $domain ),
                'type'        => 'password',
                'required'    => true,
                'class'       => ['show-hide-password'],
            ],
        ];

        $this->schema['license_login'] = [
            'email'         => [
                'label'       => __( 'User email', $domain ),
                'type'        => 'email',
                'placeholder' => __( 'User email', $domain ),
            ],
            'personal_code' => [
                'label'       => __( 'Personal code', $domain ),
                'type'        => 'password',
                'placeholder' => __( 'Personal code', $domain ),
            ],
        ];

        $this->schema['geo_files_info'] = [
            'first_name'   => [
                'label'       => __( 'First name', $domain ),
                'placeholder' => __( 'First name', $domain ),
                'required'    => true,
            ],
            'last_name'    => [
                'label'       => __( 'Last name', $domain ),
                'placeholder' => __( 'Last name', $domain ),
                'required'    => true,

            ],
            'user_email'   => [
                'label'       => __( 'User email', $domain ),
                'placeholder' => __( 'User email', $domain ),
                'type'        => 'email',
                'required'    => true,

            ],
            'mobile'       => [
                'label'       => __( 'Mobile', $domain ),
                'placeholder' => __( 'Mobile (i.e +45 number', $domain ),
                'required'    => true,

            ],
            'company'      => [
                'label'       => __( 'Company/Organization', $domain ),
                'placeholder' => __( 'Company/Organization', $domain ),
                'required'    => true,

            ],
            'address1'     => [
                'label'       => __( 'Address', $domain ),
                'placeholder' => __( 'Address', $domain ),
                'required'    => true,

            ],
            'address2'     => [
                'label'       => __( 'Address', $domain ),
                'placeholder' => __( 'Address', $domain ),
            ],
            'zip'          => [
                'label'       => __( 'Zip', $domain ),
                'placeholder' => __( 'Zip', $domain ),
                'required'    => true,

            ],
            'city'         => [
                'label'       => __( 'City', $domain ),
                'placeholder' => __( 'City', $domain ),
                'required'    => true,

            ],
            'user_country' => [
                'label'       => __( 'Country', $domain ),
                'placeholder' => __( '- Select country -', $domain ),
                'type'        => 'select',
                'options'     => Processor::txtfile2array( GEOMIFY_RESOURCE_PATH . 'countries.txt' ),
                'required'    => true,

            ],
            'data_type'    => [
                'label'       => __( 'Select data type' ),
                'placeholder' => __( ' - Select data type - ' ),
                'type'        => 'select',
                'options'     => Processor::txtfile2array( GEOMIFY_RESOURCE_PATH . 'data_types.txt' ),
            ],
            'file_country' => [
                'label'       => __( 'Select country' ),
                'placeholder' => __( ' - Select country - ' ),
                'type'        => 'select',
                'options'     => Processor::txtfile2array( GEOMIFY_RESOURCE_PATH . 'countries.txt' ),
                'required'    => true,

            ],
            'location'     => [
                'label'       => __( 'Location' ),
                'placeholder' => __( 'Type in location (Region, Municipality or City)' ),
                'required'    => true,

            ],
            'description'  => [
                'label'       => __( 'Description' ),
                'placeholder' => __( 'Why is this dataset of interest to other GEOMIFY users and what value to think it will bring to the public' ),
                'type'        => 'textarea',
                'required'    => true,

            ],
            'created_at'   => [
                'label' => __( 'Created at' ),
            ],
            'user_id'      => [
                'label' => __( 'User ID' ),
            ],
        ];

        $this->schema['geo_files'] = [
            'file_url'    => [
                'label'       => __( 'File URL', $domain ),
                'placeholder' => __( 'File URL', $domain ),
            ],
            'file_path'   => [
                'label'       => __( 'File path', $domain ),
                'placeholder' => __( 'File path', $domain ),
            ],
            'file_info'   => [

            ],
            'uploaded_at' => [

            ],
            'geo_id'      => [
                'label' => __( 'Contact ID' ),
                'type'  => 'number',
            ],
        ];

        $this->schema['newsletter'] = [
            'email'          => [
                'label' => __( 'Email', $domain ),
                'type'  => 'email',
            ],
            'date_activated' => [
                'label' => __( 'Date activated', $domain ),                
            ],
            'subscribed'     => [
                'label' => __( 'Subscribed', GTD ),
            ],
        ];

        $this->schema['enterprise_quotes'] = [
            'email'        => [
                'label' => __( 'Email address', $domain ),
                'type'  => 'email',
            ],
            'first_name'   => [
                'label' => __( 'First name' ),
            ],
            'last_name'    => [
                'label' => __( 'Last name' ),
            ],
            'office_phone' => [
                'label' => __( 'Office phone +' ),
            ],
            'mobile'       => [
                'label' => __( 'Mobile +' ),
            ],
            'time'         => [
                'label' => __( 'Time' ),
            ],
        ];

        $this->schema['partner_programs_request'] = [
            'company'                 => [
                'label'    => __( 'Company name', $domain ),
                'required' => true,
            ],
            'location'                => [
                'label'    => __( 'Location', $domain ),
                'type'     => 'select',
                'options'  => Processor::txtfile2array( GEOMIFY_RESOURCE_PATH . 'countries.txt' ),
                'required' => true,
            ],
            'street_address'          => [
                'label'    => __( 'Street address', $domain ),
                'required' => true,
            ],
            'zip_code'                => [
                'label'    => __( 'Zip code', $domain ),
                'required' => true,
            ],
            'city'                    => [
                'label'    => __( 'City', $domain ),
                'required' => true,
            ],
            'first_name'              => [
                'label'       => __( 'Name', $domain ),
                'placeholder' => __( 'First', $domain ),
                'required'    => true,
            ],
            'last_name'               => [
                'placeholder' => __( 'Last', $domain ),
                'use_label'   => false,
                'required'    => true,
            ],
            'email'                   => [
                'label'       => __( 'Email', $domain ),
                'placeholder' => __( 'Institution email', $domain ),
                'required'    => true,
            ],
            'mobile'                  => [
                'label'       => __( 'Mobile phone', $domain ),
                'placeholder' => __( 'Country code + mobile or direct number', $domain ),
                'required'    => true,
            ],
            'interest'                => [
                'label'       => __( "I'm interested in becoming" ),
                'placeholder' => __( ' - Select partner type - ' ),
                'type'        => 'select',
                'options'     => [],
                'required'    => true,
            ],
            'target_type_of_users'    => [
                'label'    => __( 'Specify target type of users' ),
                'required' => true,
            ],
            'potential_reach'         => [
                'label'    => __( 'Potential reach with GEOMIFY' ),
                'required' => true,
            ],
            'other_products_services' => [
                'label'    => __( 'Specify other products and services that you offer' ),
                'required' => true,
            ],
            'already_have_prospects'  => [
                'label'       => __( 'Indicate if you already have prospects for GEOMIFY' ),
                'placeholder' => __( ' - Select Yes/No - ' ),
                'type'        => 'select',
                'options'     => [
                    'Yes' => __( 'Yes' ),
                    'No'  => __( 'No' ),
                ],
                'required'    => true,
            ],
            'planned_investments'     => [
                'label'       => __( 'Planned investments in marketing and sales' ),
                'placeholder' => __( ' - Select budget in EUR' ),
                'type'        => 'select',
                'options'     => [

                ],
                'required'    => true,
            ],
            'strategy'                => [
                'label'    => __( 'Share keywords ragarding your strategy' ),
                'type'     => 'textarea',
                'required' => true,
            ],
            'time'                    => [
                'label'    => __( 'Time' ),
                'required' => true,
            ],
        ];
    }

    /**
     * Returns a schema
     *
     * @param  string         $schema_name
     * @return array|object
     */
    public static function get( $schema_name ) {
        $self = new self();
        return $self->schema[$schema_name];
    }

    /**
     * Returns a settings
     *
     * @param  string  $settings_name
     * @return array
     */
    public static function get_settings( $settings_name ) {
        $core    = self::get( 'settings' )[$settings_name];
        $current = get_option( self::settings_name_encode( $settings_name ), $core );

        foreach ( $core as $single => $prop ) {
            if ( ! isset( $current[$single] ) ) {
                $current[$single] = $prop;
            }
        }

        if ( sizeof( $current ) !== sizeof( $core ) ) {
            update_option( self::settings_name_encode( $settings_name ), $current );
        }

        return $current;
    }

    /**
     * Save a setting
     *
     * @param  string       $settings_name
     * @param  array|object $settings
     * @return void
     */
    public static function set_settings( $settings_name, $settings ) {
        $schema = self::get( 'settings' )[$settings_name];

        foreach ( $schema as $name => $prop ) {
            if ( ! isset( $settings[$name] ) ) {
                continue;
            }

            $schema[$name]['value'] = $settings[$name];
        }

        update_option( self::settings_name_encode( $settings_name ), $schema );
    }

    /**
     * Encoded name of setting
     *
     * @param  string   $settings_name
     * @return string
     */
    public static function settings_name_encode( $settings_name ) {
        return sprintf( 'geomify-settings-%s', $settings_name );
    }

    /**
     * Decoded name of setting
     *
     * @param  string   $settings_name
     * @return string
     */
    public static function settings_name_decode( $settings_name ) {
        return str_replace( 'geomify-settings', '', $settings_name );
    }

    /**
     * Reset all settings to default
     *
     * @return void
     */
    public static function reset_settings() {
        $settings = self::get( 'settings' );

        foreach ( $settings as $name => $prop ) {
            update_option( self::settings_name_encode( $name ), $prop );
        }
    }

    /**
     * Get a single schema item
     *
     * @param  string  $parent_path
     * @param  string  $item_name
     * @return mixed
     */
    public static function get_single( $parent_path, $item_name ) {
        return isset( self::get( $parent_path )[$item_name] ) ? self::get( $parent_path )[$item_name] : false;
    }

}