<?php \geomify\Processor\User::is_logged() or exit;
defined( 'ABSPATH' ) or exit;?>
<?php
    use geomify\Schema\CRUD;
    $table_name = CRUD::prefix() . 'project_views';
    $filter     = isset( $_POST['sort'] ) ? $_POST['sort'] : '';
    $filter_qry = '';
    switch ( $filter ) {
        case 'country-asc':
            $filter_qry = ' ORDER BY project_view_name ASC';
            break;
        case 'country-dsc':
            $filter_qry = ' ORDER BY project_view_name DESC';
            break;
        case 'industry-asc':
            $filter_qry = ' ORDER BY industry ASC';
            break;
        case 'industry-dsc':
            $filter_qry = ' ORDER BY industry DESC';
            break;
        default:
            $filter_qry = '';
            break;
    }

    if ( \geomify\Processor\User::is_current_user_admin() ) {
        $views = \geomify\Schema\CRUD::DB()->get_results(
            'SELECT * FROM ' . $table_name . $filter_qry
        );
    } else {
        if ( \geomify\Processor\User::have_permit( 'basic' ) ) {
            $views = \geomify\Schema\CRUD::DB()->get_results(
                'SELECT * FROM ' . $table_name . ' WHERE list_basic=1' . $filter_qry
            );
        } else {
            $views = \geomify\Schema\CRUD::DB()->get_results(
                'SELECT * FROM ' . $table_name . ' WHERE list_free=1' . $filter_qry
            );
        }
    }

?>
<div class="pv-toolbar">
    <?php
        if ( \geomify\Processor\User::is_current_user_admin() ) {
        ?>
    <div class="add-new-pv">
        Add new
    </div>
    <br><br>
    <?php
        }
    ?>
    <div class="tutorials-search-box">
        <select name="pv-search" id="pv-search">
            <option value="country-asc"
                <?php echo $filter == 'country-asc' || $filter == 'undefined' ? ' selected ' : '' ?>>Country (A-Z)
            </option>
            <option value="country-dsc" <?php echo $filter == 'country-dsc' ? ' selected ' : '' ?>>Country (Z-A)
            </option>
            <option value="industry-asc" <?php echo $filter == 'industry-asc' ? ' selected ' : '' ?>>Industry (A-Z)
            </option>
            <option value="industry-dsc" <?php echo $filter == 'industry-dsc' ? ' selected ' : '' ?>>Industry (Z-A)
            </option>
        </select>
        <div class="filter-pv">Filter</div>
    </div>
    <br>

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
                            <div class="project-view-item-col">%s%s%s</div>
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
    jQuery(`.filter-pv`).on(`click`, function(e) {
        getPv();
    })
    </script>
</div>