<?php
require_once("../../src/initialize.php");

$file = File::initialize_upload("fileToUpload");
$file->check();
$file->upload();

if($file->type == "kml")
    $style = "Hello";
else if ($file->type == "geojson")
    $style = "Bye";

Layer::add_to_db($file->name, $file->target_file, $style);
