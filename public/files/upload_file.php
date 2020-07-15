<?php
require_once("../../src/initialize.php");

$file = File::initialize_upload("fileToUpload");

$file->check();
$file->upload();

if ($file->type == "txt") {
    $file->covert_to_kml();
}

$args = [];
$args["name"] = $file->name;
$args["path"] = $file->target_file;
$args["distance"] = getLayerDistance($file->target_file);

$layer = new Layer($args);
$result = $layer->save();

echo $layer->id;
