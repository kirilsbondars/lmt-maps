<?php
require_once("../../src/initialize.php");

$id = $_GET["id"];
$result = array("success" => true);

$layer = new Layer($id);

if(file_exists($layer->target_file)) {
    unlink($layer->target_file);
    $layer->delete_from_db();
} else {
    $result["success"] = false;
}

echo json_encode($result);