<?php
    
if (!class_exists('Vesta')) die('Vesta is not defined.'); 

// Read server name
exec(VESTA_CMD . "v-inligo-server-name get", $server_name);

$server_name = implode('', $server_name);

?>

<div class="l-center units vestacp-web-apps">
    <?php @include_once('/usr/local/vesta/plugins/vesta-inligo-apps/web/templates/install-app.php'); ?>
    <hr>
    <?php @include_once('/usr/local/vesta/plugins/vesta-inligo-apps/web/templates/nginx-port.php'); ?>
    <hr>
    <?php @include_once('/usr/local/vesta/plugins/vesta-inligo-apps/web/templates/backup.php'); ?>
</div>