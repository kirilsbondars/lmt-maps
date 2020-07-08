<?php
require_once("../../src/initialize.php");

$id = $_GET["id"];

$layer = Layer::initialiseID($id);

if(empty($layer)) {
    exit();
}

if(file_exists($layer->target_file)) {
    unlink($layer->target_file);
}
$layer->delete_from_db();