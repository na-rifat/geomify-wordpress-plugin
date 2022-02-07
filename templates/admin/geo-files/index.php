<?php \geomify\Processor\User::is_logged() or exit; defined('ABSPATH') or exit; ?>

<h1>Geomify - Geo files</h1>
<hr>
<br>

<?php
\geomify\File\Geolist::_show();
?>