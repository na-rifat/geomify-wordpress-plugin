<?php
    $schema = new \geomify\Schema\Schema();
    $fields = $schema::get( 'tutorials' );
    $input  = new \geomify\Processor\Input();

    if ( ! empty( geomify_var( 'filter' ) ) ) {
        $tutorials = \geomify\Schema\CRUD::DB()->get_results(
            sprintf(
                'SELECT * FROM %stutorials WHERE license="%s"',
                \geomify\Schema\CRUD::prefix(),
                geomify_var( 'filter' )
            )
        );
    } else {
        $tutorials = \geomify\Schema\CRUD::retrieve( 'tutorials' );
    }
?>
<div class="geomify-tutorials-list">
    <?php foreach ( $tutorials as $tutorial ) {
            printf(
                '<div class="tutorial-item">
                        <div>
                            <video src="%s"></video>
                            <a href="%s" class="watch-tutorial">Watch the video <i class="far fa-play-circle"></i></a>
                        </div>
                        <div>%s: %s</div>
                    </div>',
                $tutorial->file_url,
                $tutorial->file_url,
                $tutorial->license,
                $tutorial->caption
            );
    }?>
    <script>
        jQuery(document).ready(()=>{
            viewTutorial();
        })
    </script>
</div>