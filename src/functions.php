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

function is_post_request() {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_request() {
    return $_SERVER['REQUEST_METHOD'] == 'GET';
}

function generate_random_string($length = 16, $characters = '0123456789abcdefghijklmnopqrstuvwxyz') {
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generate_unique_filename($path) {
    $existing_files = scandir($path);
    do {
        $random_filename = generate_random_string();
    } while (in_array($random_filename, $existing_files));

    return $random_filename;
}

function random_element_from_array($arr) {
    $rand_index = rand(0, count($arr) - 1);
    return $arr[$rand_index];
}

function getLayerDistance($path) {
    $layer = geoPHP::load(file_get_contents($path));

    return $layer->greatCircleLength() / 1000;
}