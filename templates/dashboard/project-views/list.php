<?php
    $views = \geomify\Schema\CRUD::retrieve( 'project_views', \geomify\Processor\User::current_user_id(), 'user_id' );  
?>
<div class="pv-toolbar">
    <div class="add-new-pv">
        Add new
    </div>
    <br><br>
</div>
<div class="pv-items">
    <?php
        foreach ( $views as $view ) {
            printf(
                '<a href="%s" target="_blank">
                            <div class="project-view-item-col"><img src="%s" alt="%s"></div>
                            <div class="project-view-item-col">%s</div>
                            <div class="project-view-item-col">%s</div>
                            <div class="project-view-item-col">%s</div>
                        </a>',
                        $view->url,
                geomify_imgfile('cesium_icon.png'),
                __( 'Cesium Logo', GTD ),
                geo_sanit($view->project_view_name),
                geo_sanit($view->industry),
                '<i class="fas fa-external-link-alt"></i>'
            );
        }
    ?>
</div>