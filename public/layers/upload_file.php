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
//$args["name"] = "name of file";
//$args["path"] = "path of file";
//$args["style"] = '{"juju": "kiki"}';

$layer = new Layer($args);
$result = $layer->save();

if($result) {
    echo $layer->id . " " . $layer->name . " " . $layer->path . " " . $layer->style;
} else {
    echo json_encode($layer->errors);
}
