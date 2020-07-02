<?php
require_once("../../src/initialize.php");

check_GET_var("file");
$id = $_GET["file"];

$file_path = Layer::getPath($id);

$file = fopen($file_path, 'rb');
if ( $file !== false ) {
    while ( !feof($file) ) {
        echo fread($file, 4096);
    }
    fclose($file);
}

//echo file_get_contents($file_path);