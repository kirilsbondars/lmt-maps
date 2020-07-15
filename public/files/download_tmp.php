<?php
require_once("../../src/initialize.php");

if(!isset($_GET['file_name'])) {
    exit("Error: no file_name inputted");
}
$file_name = $_GET["file_name"];

$file_path = TMP . $file_name;

if(file_exists($file_path)) {
    header("Content-type: text/plain");
    header("Content-Disposition: attachment; filename=combined.kml");
    $file = fopen($file_path, 'rb');
    if ( $file !== false ) {
        while ( !feof($file) ) {
            echo fread($file, 4096);
        }
        fclose($file);
    }

    unlink($file_path);
}