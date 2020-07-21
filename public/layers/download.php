<?php
require_once("../../src/initialize.php");

if(!isset($_GET["id"])) {
    exit("Error: no ID inputted");
}
$id = $_GET["id"];

$layer = Layer::find_by_id($id);
if($layer == false) {
    exit("Error: no such ID in DB");
}

header("Content-Disposition: attachment; filename=" . $layer->full_name());
readfile(DATA . $layer->path);