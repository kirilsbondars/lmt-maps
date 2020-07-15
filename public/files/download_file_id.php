<?php
include_once("../../src/initialize.php");

if(!isset($_GET['id'])) {
    exit("Error: no ID inputted");
}
$id = $_GET["id"];

$layer = Layer::find_by_id($id);
if($layer == false) {
    exit("Error: no such ID in DB");
}

$path = $layer->path;

if (file_exists($path)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/vnd.google-earth.kml+xml');
    header('Content-Disposition: attachment; filename="' . $layer->full_name() . '"'); //basename($path)
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($path));
    readfile($path);
    exit;
}