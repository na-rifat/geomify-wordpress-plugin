<?php
    geo_session();
?>
<div class="email-body" style="padding: 50px 15%;
    background-color: white;
    border-bottom: 1px solid #ccc;
    text-align: center;">
    <h2>Thank You for Subscribing to BASIC!</h2>
    <p>Click the button below to ACTIVATE & LOGIN to your BASIC Subscription. Once activated, you’ll have instant access
        to
        sample data, Cesium World Terrain,
        OSM Buildings and
        much more.</p>
    <div class="button-holder" style=" margin:  20px 0; display: inline-block;">
        <a href="<?php echo isset( $_SESSION['aurl'] ) ? $_SESSION['aurl'] : site_url() ?>" class="geo-button"
            target="_blank" style=" border-radius: 3px;
    border: 2px solid #51a7f9;
    background-color: #51a7f9;
    color: #ffffff;
    padding: 12px 60px;
    text-decoration: none;
    font-weight: bold;
    transition: .3s all linear;
    text-align: center;
    display: inline-block;">
            <?php _e( 'ACTIVATE & LOGIN', GTD )?>
        </a>
    </div>
</div>