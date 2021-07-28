<?php
    $user     = new \geomify\Processor\User();
    $invoices = $user::stripe_invoices();
?>

<div class="invoice-list-holder">
    <table class="invoice-list">
        <tr>
            <th>Due</th>
            <th>Paid</th>
            <th>Date created</th>
            <th>View invoice</th>
            <th>Download PDF</th>
        </tr>
        <?php 
            foreach($invoices as $invoice){
                ?>
                    <tr>
                        <td><?php echo $invoice->amount_due / 100.00 ?> €</td>
                        <td><?php echo $invoice->amount_paid / 100.00 ?> €</td>
                        <td><?php echo date('d/m/Y', $invoice->created)?></td>
                        <td><a href="<?php echo $invoice->hosted_invoice_url ?>" target="_blank"><i class="fas fa-external-link-alt"></i></a></td>
                        <td><a href="<?php echo $invoice->invoice_pdf ?>"><i class="fas fa-file-download"></i></a></td>
                    </tr>                
                <?php
            }
        ?>
    </table>
</div>

