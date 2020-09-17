<?php

if (!class_exists('Vesta')) die('Vesta is not defined.');

$plugin_dir = '/usr/local/vesta/plugins/vesta-inligo-apps';

include_once("$plugin_dir/web/inc/util.php");

// Read server name
$server_name = sudo_vesta('v-inligo-server-name get', '');

$session_user = $_SESSION['user'];

?>

<div>
    <?php if ($user === 'admin' && !$server_name) include_once("$plugin_dir/web/templates/install-dependencies.php"); // show this first if it hasn't been executed before ?>

    <?php if ($user === 'admin') include_once("$plugin_dir/web/templates/git.php"); ?>
    <?php if ($user === 'admin') include_once("$plugin_dir/web/templates/install-app.php"); ?>
    <?php if ($user === 'admin') include_once("$plugin_dir/web/templates/backup.php"); ?>
    <?php if ($session_user === 'admin') include_once("$plugin_dir/web/templates/nginx-port.php"); ?>
    <?php if ($user === 'admin' && $server_name) include_once("$plugin_dir/web/templates/install-dependencies.php"); ?>
</div>