<?php
$target_dir = "../data/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

$result = array("success" => true, "des" => "");

// Check if file already exists
if (file_exists($target_file)) {
    $result["success"] = false;
    $result["des"] .= "Sorry, file already exists. ";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "kml" && $imageFileType != "geojson") {
    $result["success"] = false;
    $result["des"] .= "Sorry, only KML and GeoJson files are allowed. ";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $result["success"] = false;
    $result["des"] .= "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $result["des"] .= "The file ". basename( $_FILES["fileToUpload"]["name"]) . " has been uploaded.";
    } else {
        $result["success"] = false;
        $result["des"] .= "Sorry, there was an error uploading your file.";
    }
}

echo json_encode($result);