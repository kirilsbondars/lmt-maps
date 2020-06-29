<?php
require_once("../../src/initialize.php");

$file = new File();
$file->upload_name = "fileToUpload";
$file->upload();

$layer = new Layer();
$layer->name = $file->name;
$layer->target_file = $file->target_file;
$layer->style = "bye";

$layer->add_to_db();
