
<?php \geomify\Processor\User::is_logged() or exit; defined('ABSPATH') or exit; ?>

<?php
    $tutorials = \geomify\Schema\CRUD::retrieve( 'tutorials' );
?>
<div class="tutorials-list">
    <table>
        <tr>
            <th>Caption</th>
            <th>License</th>
            <th>View</th>
            <th>Uploaded at</th>
            <th>Action</th>
        </tr>
        <?php
            foreach ( $tutorials as $tutorial ) {
                printf( '<tr data-id="%s">
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                </tr>',
                    $tutorial->id,
                    $tutorial->caption,
                    $tutorial->license,
                    sprintf( '<a href="%s" target="_blank"><i class="fas fa-external-link-alt"></i></a>', $tutorial->file_url ),
                    date( 'd/m/Y', $tutorial->uploaded_at ),
                    sprintf(
                        '<a class="geomify-delete-turoial" href="%s" data-video-source-type="youtube"><i class="far fa-trash-alt"></i></a>',
                        admin_url( '?action=geomify_edit_tutorial&id=' . $tutorial->id ),
                        admin_url( '?action=geomify_delete_tutorial&id=' . $tutorial->id )
                    )
                );
            }
        ?>
    </table>
    <script>
        deleteTutorial();

    </script>
</div>