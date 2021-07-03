<?php

    $domain     = GEOMIFY_TEXT_DOMAIN;
    $form       = new \geomify\Processor\Multiform();
    $fields     = geomify\Schema\Schema::get( 'partner_programs_request' );
    $fields     = geomify\Processor\Processor::add_name_to_inputs( $fields );
    $form->name = 'partner_programs_request';

    $form->globals['use_label'] = true;

    $form->start_step();
    $form->create_field( $fields['company'] );
    $form->create_field( $fields['location'] );
    $form->create_field( $fields['street_address'] );
    $form->create_field_pair( $fields['zip_code'], $fields['city'] );
    $form->end_step();

    $form->start_step();
    $form->create_field_pair( $fields['first_name'], $fields['last_name'] );
    $form->create_field( $fields['email'] );
    $form->create_field( $fields['mobile'] );
    $form->end_step();

    $form->start_step();
    $form->create_field( $fields['interest'] );
    $form->create_field( $fields['target_type_of_users'] );
    $form->create_field( $fields['potential_reach'] );
    $form->create_field( $fields['other_products_services'] );
    $form->end_step();

    $form->start_step();
    $form->create_field( $fields['already_have_prospects'] );
    $form->create_field( $fields['planned_investments'] );
    $form->create_field( $fields['strategy'] );
    $form->end_step();

    echo $form->get();
?>
