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