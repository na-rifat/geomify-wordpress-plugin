<?php
    $user = new \geomify\Processor\User;
?>
<div class="udm-holder">
    <div class="udm-row">
        <div class="udm-col">
            <div class="udm-pp">
                <?php echo $user::avatar_name() ?>
            </div>
        </div>
        <div class="udm-col">
            <div><?php echo $user::name() ?></div>
            <div><?php echo ucwords(implode(', ', $user::current_user_roles())) ?></div>
        </div>
        <div class="udm-col">
            <i class="fas fa-bars udm-toggle"></i>
        </div>
    </div>
    <div class="udm-items">
        <div class="udmi-row">
            <div class="udmi-col">
                <div class="udm-pp">
                    <?php echo $user::avatar_name() ?>
                </div>
            </div>
            <div class="udmi-col">
                <h4><?php echo $user::name() ?></h4>
                <div><?php echo $user::email() ?></div>
            </div>
        </div>
        <div class="udmi-row">
            <ul class="udmi-links">
                <li><a href="<?php echo site_url('upgrade') ?>">Upgrade</a></li>
            </ul>
        </div>
        <hr>
        <div class="udmi-row">
            <ul class="udmi-links udmi-btop">
                <li><a href="<?php echo site_url('dashboard/project-views') ?>">Dashboard</a></li>
                <li><a href="<?php echo site_url('dashboard/my-profile') ?>">My profile</a></li>
                <li><a href="<?php echo site_url('dashboard/billing') ?>">Billing</a></li>
                <li><a href="<?php echo site_url('logout') ?>">Logout</a></li>
            </ul>
        </div>
        <hr>
        <div class="udmi-row">
            <ul class="udmi-links udmi-btop">
                <li><a href="#" class="hide-udm">Cancel</a></li>
            </ul>
        </div>
    </div>
</div>