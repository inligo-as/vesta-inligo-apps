<?php

// Include vesta functions
include($_SERVER['DOCUMENT_ROOT'] . "/inc/main.php");

$session_user = $_SESSION['user'];

function sudo_vesta($cmd, $output_glue = null) {
    exec(VESTA_CMD . $cmd, $output);
    
    if ($output_glue !== null) {
        $output = implode($output_glue, $output);
        $output = str_replace('\n', $output_glue, $output);
    }

    return $output;
}

function save_server_name($server) {    
    $cmd = "v-inligo-server-name set $server";
    $output = sudo_vesta($cmd, '<br>');
    $output = ">> $cmd <br>$output";

    return $output;
}



?>