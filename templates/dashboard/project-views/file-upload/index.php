<?php \geomify\Processor\User::is_logged() or exit; defined('ABSPATH') or exit; ?>

<div class="file-upload-section">
    <div class="gtab-holder">
        <p class="file-description">With your BASIC account you can share data with other GEOMIFY users. Follow the
            quick and easy 4 step
            process below to describe your data and why you think public access creates value to others.
            <br> <br>
            Examples of datasets useful for others: <br>
            -GEO & GIS data sets<br>-CAD data in 2D and 3D<br>
            -IFC and BIM models<br>
            -City Models and Urban Environments in 3D<br>
        </p>
    </div>
    <div class="gtab-toolbar">
        <br>
        <div class="gtab-key-1 gtab-key-2">
            <div class="key-item">1. Contact</div>
            <div class="key-item">2. Description</div>
            <div class="key-item">3. Files</div>
            <div class="key-item">4. Receipt</div>
        </div>
        <br>
    </div>
    <div class="gtab-body">
       <div class="gtab-item">
            <?php include 'contact.php'?>
        </div>
        <div class="gtab-item">
            <?php include 'description.php'?>
        </div>
        <div class="gtab-item">
            <?php include 'files.php'?>
        </div>
        <div class="gtab-item">
            <?php include 'receipt.php'?>
        </div>
    </div>
    <div class="geomify-form-submit-btn start-file-upload-session" data-step="-1">
        <i class="fas fa-sign-in-alt"></i> <span class="uppercase">Get started</span>
    </div>
</div>
