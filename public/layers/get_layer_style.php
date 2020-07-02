<?php
require_once("../../src/initialize.php");

check_GET_var("id"); //check for "id"
$id = $_GET["id"];

$style = Layer::getStyle($id);

echo $style;
