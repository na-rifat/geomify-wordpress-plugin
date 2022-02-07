<?php \geomify\Processor\User::is_logged() or exit; defined('ABSPATH') or exit; ?>
<?php
    $row     = \geomify\Schema\CRUD::get_row( 'geo_files_info', isset( $_POST['id'] ) ? $_POST['id'] : 0 );    
?>
<div class="geo-file-list-holder">
    <div class="gfl-row f-row">
        <div class="gfl-col">
            <h2>Contact info</h2>
            <table>
                <tr>
                    <th>First name</th>
                    <td><?php echo $row->first_name ?></td>
                </tr>
                <tr>
                    <th>Last name</th>
                    <td><?php echo $row->last_name ?></td>
                </tr>
                <tr>
                    <th>User email</th>
                    <td><?php echo $row->user_email ?></td>

                </tr>
                <tr>
                    <th>Mobile</th>
                    <td><?php echo $row->mobile ?></td>

                </tr>
                <tr>
                    <th>Company</th>
                    <td><?php echo $row->company ?></td>

                </tr>
                <tr>
                    <th>Address 1</th>
                    <td><?php echo $row->address1 ?></td>

                </tr>
                <tr>
                    <th>Address 2</th>
                    <td><?php echo $row->address2 ?></td>
                </tr>
                <tr>
                    <th>Zip</th>
                    <td><?php echo $row->zip ?></td>

                </tr>
                <tr>
                    <th>City</th>
                    <td><?php echo $row->city ?></td>
                </tr>
                <tr>
                    <th>Country</th>
                    <td><?php echo $row->country ?></td>
                </tr>
            </table>
        </div>
        <div class="gfl-col">
        <h2>Description</h2>
            <table>
                <tr>
                    <th>Data type</th>
                    <td><?php echo $row->data_type ?></td>
                </tr>
                <tr>
                    <th>Country</th>
                    <td><?php echo $row->file_country ?></td>
                </tr>
                <tr>
                    <th>Location</th>
                    <td><?php echo $row->location ?></td>
                </tr>
                <tr>
                    <th>Descritpion</th>
                    <td><?php echo $row->description ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="gfl-row">
        <div class="gfl-row">
            <?php \geomify\File\Geoview::_show() ?>
        </div>
    </div>
</div>