<?php
    $views = \geomify\Schema\CRUD::retrieve( 'project_views' );
?>
<div class="pv-toolbar">
    <?php
        if ( \geomify\Processor\User::is_current_user_admin() ) {
        ?>
    <div class="add-new-pv">
        Add new
    </div>
    <?php
        }
    ?>
    <br><br>
</div>
<div class="pv-items">
    <?php
        $is_admin = \geomify\Processor\User::is_current_user_admin();
        foreach ( $views as $view ) {
            printf(
                '<a href="%s" target="_blank" data-id="%s" >
                            <div class="project-view-item-col"><img src="%s" alt="%s"></div>
                            <div class="project-view-item-col des-col"><div>%s</div><div>%s</div></div>
                            <div class="project-view-item-col">%s</div>
                            <div class="project-view-item-col">%s</div>
                            <div class="project-view-item-col">%s%s</div>
                        </a>',
                $view->url,
                $view->id,
                geomify_imgfile( 'cesium_icon.png' ),
                __( 'Cesium Logo', GTD ),
                geo_sanit( $view->project_view_name ),
                geo_sanit( $view->description ),
                geo_sanit( $view->industry ),
                '<i class="fas fa-external-link-alt"></i>',
                $is_admin ? '<i class="far fa-edit edit-pv"></i>' : '',
                $is_admin ? '<i class="fas fa-trash-alt dlt-pv"></i>' : ''
            );
        }
    ?>
    <script>
        editPv();
        dltPv();
    </script>
</div>