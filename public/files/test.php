<?php
require_once("../../src/initialize.php");

$myfile = fopen(DATA . "test.kml", "r") or die("Unable to open file!");
$line = "";
$start_placemark = false;
$start_linestring = false;
$start_coordinates = false;
$end_coordinates = false;

$coordinates_str = "";
$coordinates = array();

while(!feof($myfile)) {
    $line = fgets($myfile);

    if(!$start_placemark)
    $start_placemark = strpos($line, "<Placemark>");

    if($start_placemark && !$start_linestring)
        $start_linestring = strpos($line, "<LineString>");

    if($start_placemark && $start_linestring && !$start_coordinates)
        $start_coordinates = strpos($line, "<coordinates>");

    if($start_coordinates && $start_linestring && $start_placemark) {
        $end_coordinates = strpos($line, "</coordinates>");
        $start_coordinates = $start_coordinates + strlen("<coordinates>");
        $coordinates_str = substr($line, $start_coordinates, $end_coordinates - $start_coordinates);
        array_push($coordinates, get($coordinates_str));

        $start_coordinates = false;
        $start_linestring = false;
        $start_placemark = false;
    }
}
echo json_encode($coordinates);
fclose($myfile);


function get($str) {
    $arr = array();

    $comma = 0;
    $space_first = 0;
    $space_end = 0;

    do {
        $comma = strpos($str, ",", $comma+1);
        $space_end = strpos($str, " ", $space_first+1);
        if(!$space_end)
            $space_end = strlen($str) - 1;

        $y = substr($str, $space_first, $comma - $space_first);
        $x = substr($str, $comma+1, $space_end - $comma - 1);

        $space_first = $space_end + 1;

        array_push($arr, array("x" => $x, "y" => $y));
    } while($space_first < strlen($str));

    return $arr;
}


