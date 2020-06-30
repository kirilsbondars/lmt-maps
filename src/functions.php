<?php

function get_files_names($path) {
    $files_names = array();

    if ($handle = opendir($path)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                array_push($files_names, $entry);
            }
        }
        closedir($handle);
    }

    return $files_names;
}

function error($error_message) {
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-type: text/plain');
    exit($error_message);
}

function check_GET_var($var) {
    if(empty($_GET[$var]))
        exit("You need to set " . $var . " in ajax request");
}