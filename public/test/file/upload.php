<?php
require_once("../../../src/initialize.php");

if(isset($_POST["category"]))
    $category = $_POST["category"];

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
$args["category"] = $category;

$layer = new Layer($args);
$result = $layer->save();
if($result) {
    echo $layer->id;
} else {
    $file->delete();
    error("Error uploading. Try again.");
}