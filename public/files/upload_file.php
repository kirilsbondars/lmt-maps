<?php
require_once("../../src/initialize.php");

$target_file = DATA . basename($_FILES["fileToUpload"]["name"]);
$upload_OK = 1;
$file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

$result = array("success" => true, "des" => "");

// Check if file already exists
if (file_exists($target_file)) {
    $result["success"] = false;
    $result["des"] .= "Sorry, file " . basename( $_FILES["fileToUpload"]["name"]) . " already exists. ";
    $upload_OK = 0;
}

// Allow certain file formats
if ($file_type != "kml" && $file_type != "geojson") {
    $result["success"] = false;
    $result["des"] .= "Sorry, only KML and GeoJson files are allowed. ";
    $upload_OK = 0;
}

// Check if $upload_OK is set to 0 by an error
if ($upload_OK == 0) {
    $result["success"] = false;
    $result["des"] .= "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $result["des"] .= "The file ". basename( $_FILES["fileToUpload"]["name"]) . " has been uploaded. ";
    } else {
        $result["success"] = false;
        $result["des"] .= "Sorry, there was an error uploading your file.";
    }
}

//If file type is kml convert to GeoJson
if ($file_type == "kml" && $upload_OK) {
    $geo = geoPHP::load(file_get_contents($target_file), 'kml');
    $new_file_path = substr($target_file, 0, strlen($target_file) - strlen($file_type)) . "geojson";
    $fp = fopen($new_file_path,"w");
    fwrite($fp, $geo->out('geojson'));
    fclose($fp);

    $result["des"] .= "File was converted to GeoJson. ";

    if (unlink($target_file))
        $result["des"] .= "Original file was deleted";
}

echo json_encode($result);