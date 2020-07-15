<?php
include_once("../../src/initialize.php");

if(!isset($_POST["ids"])) {
    exit("Error: no ID inputted");
}
$json = $_POST["ids"];
$ids = json_decode($json);

$new_file_name = generate_unique_filename(TMP);
$new_file_path = TMP . $new_file_name;

$myfile = fopen($new_file_path, "w") or die("Unable to open file!");
fwrite($myfile, start_kml_file());
foreach ($ids as $id) {
    $layer = Layer::find_by_id($id);
    if($layer == false) {
        exit("Error: no such ID in DB");
    }

    $file = file_get_contents($layer->path) or die("Unable to open file!");
    fwrite($myfile, "\t\t\t" .substringPlacemarks($file) . "\r\n");
}
fwrite($myfile, end_kml_file());
fclose($myfile);

echo $new_file_name;

function substringPlacemarks($content) {
    $start_of_placemark =  strpos($content, "<Placemark>");
    $end_of_placemark =  strripos($content, "</Placemark>") + strlen("</Placemark>");
    return substr($content, $start_of_placemark, $end_of_placemark - $start_of_placemark);
}