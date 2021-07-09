<?php
    $fields = \geomify\Schema\Schema::get( 'geo_files_info' );
    $fields = \geomify\Processor\Processor::add_name_to_inputs( $fields );
    $input  = new \geomify\Processor\Input();
?>

<div class="file-upload-form">
    <h3>Thank you for sharing</h3>
    <p></p>
    <form action="#">
        <div class="thanks-section">
            <h6>Your contribution means a lot to us and to all our users - Sharing data, we
                believe is a step closer to a Sustainable Future</h6>
            <p>The GEOMIFY team is now processing the submitted data and description for
                the creation of 3D tiles for making the data available in the growing list of
                Project views.</p>
            <p>If our team needs additional information, coordinates or a different fileformat
                then provided, you will hear from us.</p>
            <p>We will also inform you once your data is published.</p>
            <h6>Please check your email for a receipt and for updates!</h6>
            <span class="blue-text">Wishing you a digital reality day ahead…
            </span>
            <br>
            <p>The GEOMIFY Team</p>
        </div>
        <a href="<?php echo site_url( 'dashboard/project-views' ) ?>" class="geomify-form-submit-btn file-upload-submit-btn">
            <i class="fas fa-sign-in-alt"></i>PROJECT VIEWS</a>
    </form>
</div>