<?php
    $schema = \geomify\Schema\Schema::get( 'enterprise_quotes' );
    $input  = new \geomify\Processor\Input();
    $schema = $input::add_name_to_inputs( $schema );
    $schema = $input::convert_label_to_placeholder( $schema );
?>
<div class="new-quote">
    <form action="#" method="POST">
        <?php
            $input::create_field( $schema['email'] );
            $input::create_field_pair( $schema['first_name'], $schema['last_name'] );
            $input::create_field_pair( $schema['office_phone'], $schema['mobile'] );
        ?>
        <div class="center-button-holder">
            <div class="geomify-form-submit-btn enterprise-quote-submit">
                CONTACT ME FOR A QUOTE
            </div>
        </div>
        
    </form>
    <script>
    let $ = jQuery;
    $(`.enterprise-quote-submit`).on(`click`, function(e) {
        let self = $(this);
        let form = self.parents(`form`);
        let data = form.serialize();
        data += `&action=submit_enterprise_quote&nonce=${geomify.submit_enterprise_quote_nonce}`;

        if(geomifyValidateFields(form, `white`) == false){
            return;
        }


        $.ajax({
            type: "POST",
            url: geomify.ajax_url,
            data,
            dataType: "JSON",
            success: function(response) {
                console.log(response)
                if (response.success) {
                    form.html(response.data.page)
                } else {
                    geomifyMessage(response.data.msg, `failed`);
                }
            },
            error: function(res) {},
            complete: function(res) {},
        });
    });
    </script>
</div>