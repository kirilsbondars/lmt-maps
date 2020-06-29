<?php
require_once("../../src/initialize.php");

$layer = new Layer();
$layer->file("fileToUpload");
$layer->check();
$layer->upload();