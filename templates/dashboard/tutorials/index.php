<?php
    $schema    = new \geomify\Schema\Schema();
    $input     = new \geomify\Processor\Input();    
?>
<div class="gtab-holder">
    <div class="gtab-header">
        <div class="header-item">
            <h2>Video tutorials</h2>
            <p>Watch our Tutorials and learn more about GEOMIFY and our licensing options</p>
        </div>
    </div>
    <?php 
        if(\geomify\Processor\User::is_current_user_admin()){
            ?>
    <div class="gtab-toolbar">
        <div class="geomify-form-submit-btn new-tutorial-page new-tutorial-frontend">Add new tutorial</div>
    </div>
    <?php
        }
    ?>
    <div class="gtab-toolbar">
        <div class="tutorials-search-box">
            <select name="tutorials-search" id="tutorials-search">
                <?php 
                
                $options['all']=[
                    'label'=>__('List all', 'geomify'),
                    'placeholder'=>__('List all', 'geomify')
                ];

                $schema_options = $schema::get( 'packages' );

                foreach($schema_options as $schema_option => $val){
                    $options[$schema_option] = $val;
                }

                $input::__array2options( $options, '- Choose license type -' );
                ?>
            </select>
            <div class="filter-tutorials">Filter</div>
        </div>
    </div>

    <div class="gtab-body">
        <div class="geomify-tutorials-list-holder">
            <?php include 'list.php'; ?>
        </div>
    </div>
</div>