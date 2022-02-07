<div class="registration-success">
    <h3>ConGrats - You just created your own GEOMIFY Space with Basic subscription!</h3>
    <p>Please check your email and confirm your signup. Once
        confirmed, you’ll have instant access to sample data, Cesium
        World Terrain and OSM Buildings.</p>
    <span class="blue-text">Empower sustainable
urban planning by
sharing your data…</span>

    <br>
    <div class="geomify-form-submit-btn reset-create-space-form">
        CLOSE WINDOW
    </div>
    <script>
    jQuery(document).ready(() => {
        jQuery(`.geomify-form-submit-btn.reset-create-space-form`).on(`click`, hideLightbox)
        jQuery(`.lightbox-close`).on(`click`, function (e) {
            location.reload();
         })
    });
    </script>
</div>