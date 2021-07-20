<?php
    $sc = \geomify\Schema\Schema::get('partner_programs_request');
    unset($sc['time']);
?>
<div class="email-body"style="padding: 50px 15%;
    background-color: white;    
    border-bottom: 1px solid #ccc;    
    text-align: center;">
    <table style="text-align: left;">
        <?php
            foreach($sc as $key => $prop){
                ?>
                    <tr>
                        <th><?php echo $prop['label'] ?>:</th>
                        <td><?php echo geomify_var($key) ?></td>
                    </tr>
                <?php
            }
        ?>
    </table>
</div>