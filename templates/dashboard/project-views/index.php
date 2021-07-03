<?php
    $views = \geomify\Schema\CRUD::retrieve( 'project_views' );
?>
<div class="geomify-project-views">
    <div class="pv-header">
        <div class="header-item">
            <div class="pv-titles">
                <div class="title-item active-item">
                    <h2>Select Project View</h2>
                    <p>The selected project view will open in new browser tab</p>
                </div>
                <div class="title-item">
                    <h2>Upload project fiels</h2>
                    <p>Together we empower sutainable Urban Planning</p>
                </div>
            </div>
        </div>
        <div class="header-item">
            <div class="pv-tab-key-list">
                <div class="pv-tab-key active-item">
                    <i class="fas fa-tv"></i> Project views
                </div>
                <div class="pv-tab-key">
                    <?php echo do_shortcode( '[unlock-basic-fu-title]' ) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="pv-body">
        <div class="pv-tabs">
            <div class="tab-item pv-list active-item">

            </div>
            <div class="tab-item file-upload-holder">
                <?php include GEOMIFY_TEMPLATES_PATH . '/dashboard/project-views/file-upload/index.php' ?>
            </div>
        </div>
    </div>
</div>
<?php
//\geomify\Processor\Templates::_get('dashboard/project-views/new');
?>