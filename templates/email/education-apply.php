<?php 
    $fields = \geomify\Schema\Schema::get('educational_institutes_requests');
    unset($fields['time']);
?>
<div class="email-body" style="padding: 50px 15%;
    background-color: white;    
    border-bottom: 1px solid #ccc;    
    text-align: center;">
    <table style="text-align: left;">   
        <?php 
            foreach($fields as $field => $props){
                ?>
        <tr>
            <th><?php echo $props['label'] ?></th>
            <td><?php echo geomify_var($field) ?></td>
        </tr>
        <?php
            }
        ?>
    </table>
</div>