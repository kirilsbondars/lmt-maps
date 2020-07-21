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
$args["distance"] = get_kml_file_distance($file->target_file);

$layer = new Layer($args);
$result = $layer->save();
if($result) {
    echo $layer->id;
} else {
    $file->delete();
    error("Error uploading. Try again.");
}
