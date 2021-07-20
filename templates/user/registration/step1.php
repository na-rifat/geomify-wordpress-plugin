<?php
    $fields = \geomify\Schema\Schema::get( 'registration' );
    $fields = \geomify\Processor\Processor::add_name_to_inputs( $fields );
    $input  = new \geomify\Processor\Input();
?>
<div class="registration-step">
    <form action="#" method="POST" class="create-space-form" data-step="1">
        <?php $input::create_field( $fields['email'] )?>
<?php $input::create_field_pair( $fields['first_name'], $fields['last_name'] )?>
        <div class="submission-section">
            <div class="geomify-form-submit-btn create-space">
                Create space
            </div>
            <a href="<?php echo site_url( '/terms-of-use-privacy' )?>">View privacy policy</a>
        </div>
    </form>
    <script>
    jQuery(document).ready(() => {
        createSpace();
        showPassword();
    })
    </script>
</div>