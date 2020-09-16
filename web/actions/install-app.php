<?php

$app = trim($_POST['app']);
$web_parts = explode("|", $_POST['web_domain']);
$user_name = trim($web_parts[0]);
$web_domain = trim($web_parts[1]);

if ($user === 'admin') {
    $output = Vesta::exec('v-install-web-app', $app, $user_name, $web_domain);
} else {
    $output = __("You are not allowed to perform this action");
}

Vesta::render_cmd_output($output, __("Installing") . " $app", $_SERVER['REQUEST_URI']);
