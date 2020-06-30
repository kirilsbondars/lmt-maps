<?php
require_once("../../src/initialize.php");

$file = File::initialize_upload("fileToUpload");
$file->check();
$file->upload();

$layer = Layer::add_to_db($file->name, $file->target_file);
echo $layer->id;
