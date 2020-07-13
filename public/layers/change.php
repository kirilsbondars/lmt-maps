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

$args = $_POST["layer"];
$layer->merge_attributes($args);
$result = $layer->save();

echo $result;






