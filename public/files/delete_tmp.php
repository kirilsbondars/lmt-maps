<?php
require_once("../../src/initialize.php");

if(!isset($_GET['file_name'])) {
    exit("Error: no file_name inputted");
}
$file_name = $_GET["file_name"];

$file_path = TMP . $file_name;

if(file_exists($file_path)) {
    unlink($file_path);
}
