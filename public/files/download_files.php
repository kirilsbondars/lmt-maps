<?php
require_once("../../src/initialize.php");

if(!isset($_GET["ids"])) {
    exit("Error: no ID inputted");
}
$json = $_GET["ids"];
$ids = json_decode($json);

if(count($ids) >= 2) {
    $combination = start_kml_file();
    foreach ($ids as $id) {
        $layer = Layer::find_by_id($id);
        if($layer == false) {
            exit("Error: no such ID in DB");
        }

        $file = file_get_contents($layer->path) or die("Unable to open file!");
        $combination .= "\t\t\t" .substringPlacemarks($file) . "\r\n";
    }
    $combination .= end_kml_file();

    downloadHeaaders("combination.kml");
    echo $combination;
} elseif (count($ids) == 1) {
    $layer = Layer::find_by_id($ids[0]);
    if($layer == false) {
        exit("Error: no such ID in DB");
    }

    downloadHeaaders($layer->full_name());
    readfile($layer->path);
} else {
    exit("Input contains no layers");
}

// Functions
function substringPlacemarks($content) {
    $start_of_placemark =  strpos($content, "<Placemark>");
    $end_of_placemark =  strripos($content, "</Placemark>") + strlen("</Placemark>");
    return substr($content, $start_of_placemark, $end_of_placemark - $start_of_placemark);
}

function downloadHeaaders($file_name) {
    //header("Content-type: application/vnd.google-earth.kmz");
    header("Content-Disposition: attachment; filename=$file_name");
}