<?php
require_once("../../../src/initialize.php");

if(count($_GET) > 0) {
    if(!isset($_GET['id'])) {
        exit("Error: no inputted ID");
    }
    $id = $_GET["id"];

    $layer = Layer::find_by_id($id);
    if($layer == false) {
        exit("Error: no such ID in DB");
    }
}

$id = $layer->id;
$name = $layer->name;
$style = json_decode($layer->style, true);
$strokeColor = $style["stroke"]["color"];
$circleColor = $style["circle"]["fill"]["color"];
$distance = $layer->distance;

include "table_row.php";