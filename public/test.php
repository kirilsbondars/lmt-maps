<?php
include_once("../src/initialize.php");

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

function get_latitudes($line, $space_positions) { //56.
    return substr($line, $space_positions[6] + 1, $space_positions[7] - $space_positions[6] - 1);
}

function get_longitudes($line, $space_positions) { //24.
    return substr($line, $space_positions[7] + 1, $space_positions[8] - $space_positions[7] - 1);
}

function geo_string_to_array($str) {
    $arr = array();

    for ($i = 0; $i < strlen($str); $i += 11) {
        $coordinates = substr($str, $i, 10);
        $coordinates = make_normal_coordinates($coordinates);
        array_push($arr, $coordinates);
    }

    return $arr;
}

function make_normal_coordinates($coordinates) {
    $coordinates = str_replace(":", "", $coordinates);
    $coordinates = str_replace(".", "", $coordinates);
    $coordinates = substr_replace($coordinates, ".", 2, 0);
    return $coordinates;
}

function start_kml_file() {
    return '<?xml version="1.0" encoding="UTF-8"?><kml xmlns="http://www.opengis.net/kml/2.2"><Document>';
}

function end_kml_file() {
    return '</Document></kml>';
}

function kml_make_point($lon, $lat) {
    $kml =
        '<Placemark><Point><coordinates>' . $lon . ',' . $lat . '</coordinates></Point></Placemark>';

    return $kml;
}

function kml_line_start() {
    return '<Placemark><Style><LineStyle><color>ff0000ff</color></LineStyle><PolyStyle><fill>0</fill></PolyStyle></Style><LineString><altitudeMode>clampToGround</altitudeMode><coordinates>';
}

function kml_line_end() {
    return '</coordinates></LineString></Placemark>';
}

$lines = file('C:\Users\espero-win10\Documents\MEGA\kml_map\Riga_OKK.txt');

$myfile = fopen("test.kml", "w") or die("Unable to open file!");
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

    echo $kml_file;

//    for ($k = 0; $k < count($latitudes_arr); $k++) {
//        $kml_file .= kml_make_point($longitudes_arr[$k], $latitudes_arr[$k]);
//    }

    fwrite($myfile, $kml_file);
}

fwrite($myfile, end_kml_file());