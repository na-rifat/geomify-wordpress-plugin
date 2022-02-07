<?php
    $user = new \geomify\Processor\User();
?>
<div class="email-body" style="padding: 50px 15%;
    background-color: white;
    border-bottom: 1px solid #ccc;
    text-align: center;">
    <table style="text-align: left;">
        <tr>
            <th>First name: </th>
            <td><?php echo $user::first_name() ?></td>
        </tr>
        <tr>
            <th>Last name: </th>
            <td><?php echo $user::last_name() ?></td>
        </tr>
        <tr>
            <th>User email: </th>
            <td><?php echo $user::email() ?></td>
        </tr>
        <tr>
            <th>License type: </th>
            <td><?php echo ucwords( geomify_var( 'package_name' ) ) ?></td>
        </tr>
        <tr>
            <th>User stripe profile: </th>
            <td><a href="https://dashboard.stripe.com/test/customers/<?php echo $user::stripe_customer_id(); ?>" target="_blank">Stripe profile</a></td>
        </tr>
    </table>
</div>
