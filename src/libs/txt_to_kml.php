<?php

function get_array_of_space_positions($line) {
    $needle = "\t";
    $lastPos = 0;
    $positions = array();

    while (($lastPos = strpos($line, $needle, $lastPos))!== false) {
        $positions[] = $lastPos;
        $lastPos = $lastPos + strlen($needle);
    }

    return $positions;
}

function get_latitudes($line, $space_positions) {
    return substr($line, $space_positions[6] + 1, $space_positions[7] - $space_positions[6] - 1);
}

function get_longitudes($line, $space_positions) {
    return substr($line, $space_positions[7] + 1, $space_positions[8] - $space_positions[7] - 1);
}

function geo_string_to_array($str) {
    $arr = array();

    for ($i = 0; $i < strlen($str); $i += 11) {
        $coordinates = substr($str, $i, 10);
        $hours = substr($coordinates, 0, 2);
        $minutes = substr($coordinates, 3, 2);
        $seconds = substr($coordinates, 6);
        $decimal_hours = $hours + $minutes / 60 + $seconds / 3600;
        array_push($arr, $decimal_hours);
    }

    return $arr;
}

function start_kml_file() {
    $str = '<?xml version="1.0" encoding="UTF-8"?>' . "\r\n";
    $str .= "\t" . '<kml xmlns="http://www.opengis.net/kml/2.2">' . "\r\n";
    $str .= "\t\t" . '<Document>' . "\r\n";

    return $str;
}

function end_kml_file() {
    $str = "\t" . '</Document>' . "\r\n";
    $str .= '</kml>';

    return $str;
}

function kml_make_point($lon, $lat) {
    $kml = "\t\t\t" . '<Placemark>' . "\r\n";
    $kml .= "\t\t\t\t" . '<Point>' . "\r\n";
    $kml .= "\t\t\t\t\t" . '<coordinates>' . "\r\n";
    $kml .= $lon . ',' . $lat;
    $kml .= "\t\t\t\t\t" . '</coordinates>' . "\r\n";
    $kml .= "\t\t\t\t" . '</Point>' . "\r\n";
    $kml .= "\t\t\t" . '</Placemark>' . "\r\n";

    return $kml;
}

function kml_line_start() {
    $str = "\t\t\t" . '<Placemark>' . "\r\n";
    $str .= "\t\t\t\t" . '<LineString>' . '<altitudeMode>clampToGround</altitudeMode>' . '<coordinates>';

    return $str;
}

function kml_line_end() {
    $str = '</coordinates>' . '</LineString>' . "\r\n";
    $str .= "\t\t\t" . '</Placemark>' . "\r\n";

    return $str;
}

function convert_to_kml($source_file_path, $output_file) {
    if(!file_exists($source_file_path))
        return 0;

    if(!($lines = file($source_file_path)))
        return 0;

    if(!($myfile = fopen($output_file, "w")))
        return 0;

    fwrite($myfile, start_kml_file());

    for ($i = 1; $i < count($lines); $i++) {
        $kml_file = "";
        $line = $lines[$i];

        $space_positions = get_array_of_space_positions($line);
        $latitudes = get_latitudes($line, $space_positions);
        $longitudes = get_longitudes($line, $space_positions);
        $latitudes_arr = geo_string_to_array($latitudes);
        $longitudes_arr = geo_string_to_array($longitudes);

        $kml_file .= kml_line_start();
        for ($k = 0; $k < count($latitudes_arr); $k++) {
            $kml_file .= $longitudes_arr[$k] . "," . $latitudes_arr[$k] . " ";
        }
        $kml_file .= kml_line_end();

        fwrite($myfile, $kml_file);
    }

    fwrite($myfile, end_kml_file());

    return 1;
}