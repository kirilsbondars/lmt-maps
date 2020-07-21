<?php
require_once("../../src/initialize.php");

if(!isset($_GET["ids"])) {
    exit("Error: no ID inputted");
}
$json = $_GET["ids"];
$ids = json_decode($json);
$files_paths = get_files_path_array($ids);

if(count($ids) >= 2) {
    $combination = start_kml_file();
    foreach ($files_paths as $file_path) {
        $file = file_get_contents($file_path) or die("Unable to open file!");
        $combination .= "\t\t\t" .substring_placemarks($file) . "\r\n";
    }
    $combination .= end_kml_file();

    //header("Content-type: application/vnd.google-earth.kmz");
    header("Content-Disposition: attachment; filename=combinations.kml");

    echo $combination;
} elseif (count($ids) == 1) {
    exit("Input contains only one layer");
} else {
    exit("Input contains no layers");
}



// Functions
function get_files_path_array($ids) {
    $path_arr = array();
    foreach ($ids as $id) {
        $layer = Layer::find_by_id($id);
        if ($layer == false) {
            exit("Error: no such ID in DB");
        }
        array_push($path_arr, DATA . $layer->path);
    }

    return $path_arr;
}

function substring_placemarks($content) {
    $start_of_placemark =  strpos($content, "<Placemark>");
    $end_of_placemark =  strripos($content, "</Placemark>") + strlen("</Placemark>");
    return substr($content, $start_of_placemark, $end_of_placemark - $start_of_placemark);
}