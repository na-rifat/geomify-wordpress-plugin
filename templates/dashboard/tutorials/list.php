<?php \geomify\Processor\User::is_logged() or exit;
defined( 'ABSPATH' ) or exit;?>

<?php
    $schema = new \geomify\Schema\Schema();
    $fields = $schema::get( 'tutorials' );
    $input  = new \geomify\Processor\Input();

    if ( ! empty( geomify_var( 'filter' ) ) && geomify_var( 'filter' ) !== 'all' ) {
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
                        %s
                        <div>
                            <iframe src="%s"></iframe>
                            <a href="%s" class="watch-tutorial"  data-video-source-type="youtube"></a>
                        </div>
                        <div>%s: %s</div>
                    </div>',
                \geomify\Processor\User::is_current_user_admin() ? '<div><div class="geomify-delete-turoial" data-id="' . $tutorial->id . '" >&nbsp;<i class="far fa-trash-alt"></i></div></div>' : '',
                geomify_y2embed( $tutorial->file_url ),
                geomify_y2embed( $tutorial->file_url ),
                $tutorial->license,
                $tutorial->caption
            );
    }?>
    <script>
    jQuery(document).ready(() => {
        deleteTutorial();
        playUVideo();
    })
    </script>
</div>