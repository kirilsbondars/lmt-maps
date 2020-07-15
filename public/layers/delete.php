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

$result = $layer->delete();
if($result == false) {
    exit("Error: file was not deleted from DB");
}

if(file_exists($layer->path)) {
    unlink($layer->path);
}

echo true;