<?php

$server = trim($_POST['server']);
$aws_access_key = trim($_POST['aws_access_key']);
$aws_secret_key = trim($_POST['aws_secret_key']);

if ($user === 'admin') {
    $output = save_server_name($server) . '<br>';
    $output .= sudo_vesta("v-inligo-install-dependencies $aws_access_key $aws_secret_key", '<br>');
} else {
    $output = __("You are not allowed to perform this action");
}

Vesta::render_cmd_output($output, __("Installing dependencies"), $_SERVER['REQUEST_URI']);


?>