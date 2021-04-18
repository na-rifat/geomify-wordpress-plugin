<div class="geomify-compare-table-wrapper">
    <table>
        <thead>
            <tr>
                <th><?php _e( $s['packages_title'], $domain )?></th>
                <td><?php _e( 'FREE', $domain )?></td>
                <td><?php _e( 'BASIC', $domain )?></td>
                <td><?php _e( 'FACILITATOR', $domain )?></td>
                <td><?php _e( 'CREATOR', $domain )?></td>
                <td><?php _e( 'ENTERPRISE', $domain )?></td>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ( $s['packages'] as $package ) {
                ?>
                <tr>
            <td><?php _e( $package['feature_title'] )?></td>
            <?php
                echo geomify_compare_table_rows( $package );
                ?>
                    </tr>
               <?php
                   }
               ?>
        </tbody>
    </table>
</div>