<?php
require_once("../../src/initialize.php");

$id = $_GET["id"];

$layer = Layer::initialiseID($id);

$layer->print_table_row();