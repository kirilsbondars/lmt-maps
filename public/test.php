<?php
require_once("../src/phayes-geoPHP/geoPHP.inc");

$geo = geoPHP::load(file_get_contents('./data/PLS2.kml'), 'kml');

$fp = fopen("./PLS1.geojson","w");
fwrite($fp, $geo->out('geojson'));
fclose($fp);