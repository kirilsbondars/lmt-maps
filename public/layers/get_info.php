<?php
require_once("../../src/initialize.php");

check_GET_var("id");

$id = $_GET["id"];

$layer = Layer::initialiseID($id);

echo json_encode($layer->getArray());
