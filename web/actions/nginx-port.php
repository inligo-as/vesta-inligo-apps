<?php

$web_parts = explode("|", $_POST['web_domain']);
$user_name = trim($web_parts[0]);
$web_domain = trim($web_parts[1]);
$port = trim($_POST['port']);

$output = '';

if ($user === $user_name && $session_user === 'admin') { 
    $port = intval($port);

    if ($port >= 1000 && $port <= 10000) {
        $conf_file = "/home/$user_name/web/$web_domain/private/app.nginx.conf";
        $output = sudo_vesta("v-inligo-save-app-config $user_name $web_domain $port");
        $output = implode('<br>', $output);
    } else {
        $output = 'Port must be a numeric value between 1000 and 10000.';
    }
} else {
    $output = __("Only $user_name authenticated through admin is allowed to perform this action - you are $user ($session_user).");
}

Vesta::render_cmd_output($output, __("Set application port"), $_SERVER['REQUEST_URI']);

?>
