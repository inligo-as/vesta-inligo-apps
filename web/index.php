<?php

function save_server_name($server) {
    $server_name_path = '/usr/local/vesta/plugins/vesta-inligo-apps/plugin-data/server-name.txt';
    
    Vesta::exec("echo $server > $server_name_path");
}

// Tab name
$TAB = "Web Apps";

// Include vesta functions
include($_SERVER['DOCUMENT_ROOT'] . "/inc/main.php");

$session_user = $_SESSION['user'];

if (isset($_POST['action']) && $_POST['action'] == "install"
    && isset($_POST['app']) && !empty($_POST['app'])
    && isset($_POST['web_domain']) && !empty($_POST['web_domain'])
) {
    $app = trim($_POST['app']);
    $web_parts = explode("|", $_POST['web_domain']);
    $user_name = trim($web_parts[0]);
    $web_domain = trim($web_parts[1]);

    if ($user === 'admin' || $user === $user_name) {
        $output = Vesta::exec('v-install-web-app', $app, $user_name, $web_domain);
    } else {
        $output = __("You are not allowed to perform this action");
    }

    Vesta::render_cmd_output($output, __("Installing") . " $app", $_SERVER['REQUEST_URI']);

} else if(isset($_POST['action']) && $_POST['action'] == "backup"
    && isset($_POST['sub_action']) && $_POST['sub_action'] == "restore"
    && isset($_POST['user']) && !empty($_POST['user'])
    && isset($_POST['date']) && !empty($_POST['date'])
    && isset($_POST['server']) && !empty($_POST['server'])
) {
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

} else if (isset($_POST['server']) && !empty($_POST['server']) && $user === 'admin') {
    $server = trim($_POST['server']);
    save_server_name($server);
    $output = __("Set server name to $server.");
    Vesta::render_cmd_output($output, __("Setting server name"), $_SERVER['REQUEST_URI']);

} else if (isset($_POST['action']) && $_POST['action'] == "set_application_port"
    && isset($_POST['web_domain']) && !empty($_POST['web_domain'])
    && isset($_POST['port']) && !empty($_POST['port'])
) {
    $web_parts = explode("|", $_POST['web_domain']);
    $user_name = trim($web_parts[0]);
    $web_domain = trim($web_parts[1]);
    $port = trim($_POST['port']);

    $output = '';

    if ($user === $user_name && $session_user === 'admin') { 
        $port = intval($port);

        if ($port >= 1000 && $port <= 10000) {
            $conf_file = "/home/$user_name/web/$web_domain/private/app.nginx.conf";
            $conf = "proxy_pass http://127.0.0.1:$port;";
            $output = Vesta::exec("echo '$conf' 2>&1 > $conf_file");
            
            if ($output) $output = "Error: Failed to write to $conf_file: $output. Current user: $user ($session_user)";
            else $output = "Successfully saved new config to $conf_file: $conf\nChange nginx proxy now under domain settings.";
        } else {
            $output = 'Port must be a numeric value between 1000 and 10000.';
        }
    } else {
        $output = __("Only $user_name authenticated through admin is allowed to perform this action - you are $user ($session_user).");
    }
    
    Vesta::render_cmd_output($output, __("Set application port"), $_SERVER['REQUEST_URI']);
} else {
    Vesta::render("/templates/plugin.php", ['plugin' => 'vesta-inligo-apps', 'data' => $data]);
}
