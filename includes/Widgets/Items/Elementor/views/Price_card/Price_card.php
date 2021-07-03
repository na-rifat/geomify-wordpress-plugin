<div class="geomify-price-card">
    <div class="price-card-row">
        <img <?php echo $package_image_attr ?>>
    </div>
    <div class="price-card-row">
        <h2 <?php echo $title_attr ?>><?php _e( $s['title'], $domain )?></h2>
    </div>
    <div class="price-card-row">
        <h4 <?php echo $subtitle_attr ?>><?php _e( $s['subtitle'], $domain )?></h4>
    </div>
    <div class="price-card-row">
        <p <?php echo $description_attr ?>><?php _e( $s['description'], $domain )?></p>
    </div>
    <div class="price-card-row">
        <a <?php echo $button_title_attr ?>><?php _e( $s['button_title'], $domain )?></a>
    </div>
    <div class="price-card-row">
        <div <?php echo $period_attr ?>><?php _e( $s['period'], $domain )?></div>
        <a <?php echo $bottom_link_title_attr ?>><?php _e( $s['bottom_link_title'], $domain )?></a>
    </div>
</div>