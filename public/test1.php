<?php
require_once("../src/initialize.php");

$path = DATA . "d6473lxavbs9dyxz.kml";
$layer = geoPHP::load(file_get_contents($path));

echo $layer->greatCircleLength() / 1000 . " km";