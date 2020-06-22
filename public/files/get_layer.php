<?php
require_once("../../src/initialize.php");

$file_path = DATA . $_GET["file"];

$file = fopen($file_path, 'rb');
if ( $file !== false ) {
    while ( !feof($file) ) {
        echo fread($file, 4096);
    }
    fclose($file);
}