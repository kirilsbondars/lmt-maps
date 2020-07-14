<?php
include_once("../../src/initialize.php");

//if(!isset($_POST["ids"])) {
//    exit("Error: no ID inputted");
//}
//$json = $_POST["ids"];
//$ids = json_decode($json);
//
//foreach ($ids as $id) {
//    $layer = Layer::find_by_id($id);
//    if($layer == false) {
//        exit("Error: no such ID in DB");
//    }
//
//    echo $layer->path;
//}

$a = "C:/xampp/htdocs/lmt-maps/src/data/cs8nrs66v84my8sa.kml";
$b = "C:/xampp/htdocs/lmt-maps/src/data/eoycy4nbrzhfhm2p.kml";

function start_kml_file() {
    return '<?xml version="1.0" encoding="UTF-8"?><kml xmlns="http://www.opengis.net/kml/2.2"> <Document>';
}

function end_kml_file() {
    return '</Document></kml>';
}

$file_a = file_get_contents($a);

//
//if (file_exists($path)) {
//    header('Content-Description: File Transfer');
////    header('Content-Type: application/vnd.google-earth.kml+xml');
//    header('Content-Disposition: attachment; filename="' . $layer->full_name() . '"'); //basename($path)
//    header('Expires: 0');
//    header('Cache-Control: must-revalidate');
//    header('Pragma: public');
//    header('Content-Length: ' . filesize($path));
//    readfile($path);
//    exit;
//}