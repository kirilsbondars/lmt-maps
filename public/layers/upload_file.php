<?php
require_once("../../src/initialize.php");

$file = File::initialize_upload("fileToUpload");

$file->check();
$file->upload();

if ($file->type == "txt") {
    $file->covert_to_kml();
}

$layer = Layer::add_to_db($file->name, $file->target_file);
echo $layer->id;
