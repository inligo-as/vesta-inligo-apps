<?php

$date = trim($_POST['date']);
$time = trim($_POST['time']);
$_user = trim($_POST['user']);
$server = trim($_POST['server']);

if ($time) $time = str_replace(':', '-', $time);

if ($user === 'admin') {
    save_server_name($server);
    $output = Vesta::exec('v-inligo-restore-backup', $server, $_user, $date, $time);
} else {
    $output = __("You are not allowed to perform this action");
}

Vesta::render_cmd_output($output, __("Restoring") . " $user", $_SERVER['REQUEST_URI']);

?>