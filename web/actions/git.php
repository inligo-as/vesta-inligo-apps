<?php

$web_parts = explode("|", $_POST['web_domain']);
$user_name = trim($web_parts[0]);
$web_domain = trim($web_parts[1]);
$source_path = trim($_POST['source_path']);
$deploy_cmd = trim($_POST['deploy_cmd']);

if ($user === 'admin') {
    $output = sudo_vesta("v-inligo-create-git-repo $web_domain $user_name $source_path '$deploy_cmd'", '<br>');
} else {
    $output = __("You are not allowed to perform this action");
}

Vesta::render_cmd_output($output, __("Creating git repository") . " $app", $_SERVER['REQUEST_URI']);
