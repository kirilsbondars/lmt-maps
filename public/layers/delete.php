<?php
require_once("../../src/initialize.php");

$id = $_GET["id"];
$result = array("success" => true);

$layer = new Layer();
$layer->id = $id;
$layer->data_from_db();

$file = new File();
$file->target_file = $layer->target_file;

if ($file->delete()) {
    $result["success"] = false;
}

echo json_encode($result);