<?php
require_once("../../../src/initialize.php");

if(!isset($_POST['id'])) {
    exit("Error: no ID inputted");
}
$id = $_POST["id"];

$layer = Layer::find_by_id($id);
if($layer == false) {
    exit("Error: no such ID in DB");
}

$arr = $layer->getPublicDataArray();

echo json_encode($arr);