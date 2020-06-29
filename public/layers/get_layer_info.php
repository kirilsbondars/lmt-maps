<?php
require_once("../../src/initialize.php");

$id = $_GET["id"];

$layer = new Layer($id);

//array("name" => $layer->name, "style" => )