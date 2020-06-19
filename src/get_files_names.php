<?php

function get_files_names() {
    $files_names = array();

    if ($handle = opendir(ROOT . '/public/data')) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                array_push($files_names, $entry);
            }
        }
        closedir($handle);
    }

    return $files_names;
}