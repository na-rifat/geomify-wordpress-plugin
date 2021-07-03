<?php
    $fields  = \geomify\Schema\Schema::get( 'registration' );
    $fields  = \geomify\Processor\Processor::add_name_to_inputs( $fields );
    $input   = new \geomify\Processor\Input();
    $user_id = isset( $_GET['user'] ) ? $_GET['user'] : 0;
    $key     = isset( $_GET['key'] ) ? $_GET['key'] : '';
?>
<div class="gtab-holder">
    <div class="gtab-header">
        <div class="header-item">
            <h2>User account activation</h2>
            <p>Please enter a password to continue, password should be 8 characters or more.</p>
        </div>
    </div>
    <div class="gtab-body">
        <div class="user-activation">
            <form method="POST" action="#" data-key="<?php echo $key ?>" data-user="<?php echo $user_id ?>">
                <?php $input::create_field( $fields['password'] )?>
                <?php $input::create_field( $fields['confirm_password'] )?>
                <div class="show-hide-password-section">
                    <input type="checkbox" class="show-password" id="show_password"><label for="show_password">Show
                        password</label>
                </div>
                <div class="submission-section">
                    <div class="geomify-form-submit-btn activate-user">Activate</div>
                </div>
            </form>
        </div>
    </div>
</div>