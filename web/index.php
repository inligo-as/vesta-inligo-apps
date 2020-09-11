<?php

function save_server_name($server) {
    $server_name_path = '/usr/local/vesta/plugins/vesta-inligo-apps/plugin-data/server-name.txt';
    $f = fopen($server_name_path, 'w');

    if (!$f) return false;

    fwrite($f, $server);
    fclose($f);

    echo "Saved server name: $server";

    return true;
}

// Tab name
$TAB = "Web Apps";

// Include vesta functions
include($_SERVER['DOCUMENT_ROOT'] . "/inc/main.php");

if (isset($_POST['action']) && $_POST['action'] == "install"
    && isset($_POST['app']) && !empty($_POST['app'])
    && isset($_POST['web_domain']) && !empty($_POST['web_domain'])
) {
    $app = trim($_POST['app']);
    $web_parts = explode("|", $_POST['web_domain']);
    $user_name = trim($web_parts[0]);
    $web_domain = trim($web_parts[1]);

    if ($user == 'admin' || $user === $user_name) {
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
    $user = trim($_POST['user']);
    $server = trim($_POST['server']);

    if ($user == 'admin') {
        if (!save_server_name($server)) {
            $output = __("Failed to save server name");
        } else {
            $output = Vesta::exec('echo', $server, $user, $date, $time);
        }
    } else {
        $output = __("You are not allowed to perform this action");
    }

    Vesta::render_cmd_output($output, __("Restoring") . " $user", $_SERVER['REQUEST_URI']);
} else {
    Vesta::render("/templates/plugin.php", ['plugin' => 'vesta-inligo-apps', 'data' => $data]);
}
