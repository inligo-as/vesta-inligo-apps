<?php

if (isset($_POST['action']) && $_POST['action'] == "install"
    && isset($_POST['app']) && !empty($_POST['app'])
    && isset($_POST['web_domain']) && !empty($_POST['web_domain'])
) {
    @include_once("$plugin_dir/web/actions/install-app.php");

} else if(isset($_POST['action']) && $_POST['action'] == "backup"
    && isset($_POST['sub_action']) && $_POST['sub_action'] == "restore"
    && isset($_POST['user']) && !empty($_POST['user'])
    && isset($_POST['date']) && !empty($_POST['date'])
    && isset($_POST['server']) && !empty($_POST['server'])
) {
    @include_once("$plugin_dir/web/actions/backup.php");

} else if (isset($_POST['action']) && $_POST['action'] == "set_application_port"
    && isset($_POST['web_domain']) && !empty($_POST['web_domain'])
    && isset($_POST['port']) && !empty($_POST['port'])
) {
    @include_once("$plugin_dir/web/actions/nginx-port.php");

} else if (isset($_POST['action']) && $_POST['action'] == "create_git_repo"
    && isset($_POST['web_domain']) && !empty($_POST['web_domain'])
    && isset($_POST['source_path']) && !empty($_POST['source_path'])
) {
    @include_once("$plugin_dir/web/actions/git.php");

} else if (isset($_POST['action']) && $_POST['action'] == "install_deps"
    && isset($_POST['server']) && !empty($_POST['server'])
    && isset($_POST['aws_access_key']) && !empty($_POST['aws_access_key'])
    && isset($_POST['aws_secret_key']) && !empty($_POST['aws_secret_key'])
){
    @include_once("$plugin_dir/web/actions/dependencies.php");

} else if (isset($_POST['server']) 
    && !empty($_POST['server']) 
    && $user === 'admin'
) {
    $server = trim($_POST['server']);
    $output = save_server_name($server);
    Vesta::render_cmd_output($output, __("Setting server name"), $_SERVER['REQUEST_URI']);
} else {
    Vesta::render("/templates/plugin.php", ['plugin' => 'vesta-inligo-apps', 'data' => $data]);
}
