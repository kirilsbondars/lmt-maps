<?php

function get_kml_file_distance($path) {
    $length = 0;
    $xy_str_arr = get_XY_array_str($path);
    $xy_arr = array();

    for ($i = 0; $i < count($xy_str_arr); $i++) {
        $xy_str = $xy_str_arr[$i];
        if(!empty($xy_str))
            array_push($xy_arr, get_coordinates($xy_str));
    }

    for ($i = 0; $i < count($xy_arr); $i++) {
        for ($k = 1; $k < count($xy_arr[$i]["x"]); $k++) {
            $length += haversineGreatCircleDistance($xy_arr[$i]["x"][$k-1], $xy_arr[$i]["y"][$k-1], $xy_arr[$i]["x"][$k], $xy_arr[$i]["y"][$k]);
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

function get_XY_array_str($path) {
    $file_coor = fopen($path, "r") or die("Unable to open file!");
    $line = "";
    $start_placemark = false;
    $start_linestring = false;
    $start_coordinates = false;
    $end_coordinates = false;

    $coordinates_str = "";
    $coordinates_arr_str = array();

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
            array_push($coordinates_arr_str, $coordinates_str);

            $start_coordinates = false;
            $start_linestring = false;
            $start_placemark = false;
        }
    }
    fclose($file_coor);

    return $coordinates_arr_str;
}

function get_coordinates($str) {
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


