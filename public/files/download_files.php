<?php
include_once("../../src/initialize.php");

//if(!isset($_POST["ids"])) {
//    exit("Error: no ID inputted");
//}
//$json = $_POST["ids"];
//$ids = json_decode($json);
//
//foreach ($ids as $id) {
//    $layer = Layer::find_by_id($id);
//    if($layer == false) {
//        exit("Error: no such ID in DB");
//    }
//
//    echo $layer->path;
//}

$a = "C:/wamp64/www/lmt-maps/src/data/aw7dktsi13ix6u0a.kml";
$b = "C:/wamp64/www/lmt-maps/src/data/n0a76ertwjhcgtni.kml";

$file_a = file_get_contents($a) or die("Unable to open file!") ;
$start_of_placemark =  strpos($file_a, "<Placemark>");
$end_of_placemark =  strripos($file_a, "</Placemark>") + strlen("</Placemark>");

$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
fwrite($myfile, substr($file_a, $start_of_placemark, $end_of_placemark - $start_of_placemark));

fclose($myfile);

//
//if (file_exists($path)) {
//    header('Content-Description: File Transfer');
////    header('Content-Type: application/vnd.google-earth.kml+xml');
//    header('Content-Disposition: attachment; filename="' . $layer->full_name() . '"'); //basename($path)
//    header('Expires: 0');
//    header('Cache-Control: must-revalidate');
//    header('Pragma: public');
//    header('Content-Length: ' . filesize($path));
//    readfile($path);
//    exit;
//}