<?php
    $fields = \geomify\Schema\Schema::get( 'geo_files_info' );
    $fields = \geomify\Processor\Processor::add_name_to_inputs( $fields );
    $input  = new \geomify\Processor\Input();
?>

<div class="file-upload-form">
    <h3>Upload your files</h3>
    <p>GEO, GIS, CAD, BIM/IFC, LiDAR & PointCloud</p>
    <form action="#" id="file-selector">
        <div class="geomify-file-uploader">
            <h4>Drag and drop file here</h4>
            <p>or <a href="#" class="choose-file">Choose file</a> </p>
        </div>
        <div class="file-que">
            <!-- <div class="que-row">
                <div class="que-col">
                    FILE:
                </div>
                <div class="que-col">
                    <div class="prgs-holder">
                        <div class="prgs-row">
                            <div class="prgs-col">
                                Upload progress
                            </div>
                            <div class="prgs-col">
                                    <div class="upload-prc"></div>%
                            </div>
                        </div>
                        <div class="prgs-row">
                            <div class="prgs-col">
                                <div class="prgs-prc">
                                    <div class="current-prc"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="que-col">

                </div>
            </div> -->
        </div>
        <div class="agreement-section"> <input type="checkbox" name="i_hearby" id="i_hearby">
            <label for="i_hearby">I hereby consent to sharing my data in Project Views and the rights to use the
                provider
                information in promoting
                GEOMIFY in press releases, news updates and in Social Media.* </label>
        </div>
        <br>
        <div class="geomify-form-submit-btn file-upload-submit-btn final-submission"> <i
                class="fas fa-sign-in-alt"></i>SUBMIT</div>
    </form>
</div>