<?php
require_once("../../src/initialize.php");

//$xy = get_XY_array("C:/Users/espero-win10/Documents/MEGA/data/kml/PLS1.kml");

echo vincentyGreatCircleDistance(56.958327, 24.254890, 56.938968, 24.091208);

function vincentyGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000) {
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $lonDelta = $lonTo - $lonFrom;
    $a = pow(cos($latTo) * sin($lonDelta), 2) +
        pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
    $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

    $angle = atan2(sqrt($a), $b);
    return $angle * $earthRadius;
}

function get_XY_array($path) {
    $file_coor = fopen($path, "r") or die("Unable to open file!");
    $line = "";
    $start_placemark = false;
    $start_linestring = false;
    $start_coordinates = false;
    $end_coordinates = false;

    $coordinates_str = "";
    $x = array();
    $y = array();

    while(!feof($file_coor)) {
        $line = fgets($file_coor);

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
            $temp = getCoordinates($coordinates_str);
            for ($i = 0; $i < count($temp); $i++) {
                array_push($y, $temp[$i]["y"]);
                array_push($x, $temp[$i]["x"]);
            }

            $start_coordinates = false;
            $start_linestring = false;
            $start_placemark = false;
        }
    }
    fclose($file_coor);

    return array("x" => $x, "y" => $y);
}

function getCoordinates($str) {
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


