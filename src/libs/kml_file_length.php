<?php

function get_kml_file_distance($path) {
    $length = 0;
    $xy = get_XY_array($path);

    for ($i = 0; $i < count($xy); $i++) {
        for ($k = 1; $k < count($xy[$i]["x"]); $k++) {
            $length += haversineGreatCircleDistance($xy[$i]["x"][$k-1], $xy[$i]["y"][$k-1], $xy[$i]["x"][$k], $xy[$i]["y"][$k]);
        }
    }

    return $length / 1000;
}

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

function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000) {
    // convert from degrees to radians
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
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
    $coordinates_arr = array();

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
            array_push($coordinates_arr, getCoordinates($coordinates_str));

            $start_coordinates = false;
            $start_linestring = false;
            $start_placemark = false;
        }
    }
    fclose($file_coor);

    return $coordinates_arr;
}

function getCoordinates($str) {
    $x_arr = array();
    $y_arr = array();

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

        array_push($x_arr, $x);
        array_push($y_arr, $y);
    } while($space_first < strlen($str));

    return array("x" => $x_arr, "y" => $y_arr);
}


