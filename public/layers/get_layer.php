<?php
require_once("../../src/initialize.php");

if(!isset($_GET['id'])) {
    exit("Error: no ID inputted");
}
$id = $_GET["id"];

$layer = Layer::find_by_id($id);
if($layer == false) {
    exit("Error: no such ID in DB");
}

//$file = fopen($layer->path, 'rb');
//if ( $file !== false ) {
//    while ( !feof($file) ) {
//        echo fread($file, 4096);
//    }
//    fclose($file);
//}

echo file_get_contents($layer->path);