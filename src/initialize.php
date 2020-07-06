<?php
define("SRC", __DIR__ . "/");
define("DATA", SRC . "data/");

require_once(SRC . "functions.php");
require_once(SRC . "libs/phayes-geoPHP/geoPHP.inc");
require_once(SRC . "libs/txt_to_kml.php");
require_once(SRC . "database_functions.php");
foreach (glob(SRC . "classes/*.php") as $filename) {
    require_once($filename);
}

$database = db_connect();
DatabaseObject::set_database($database);

if(!file_exists(DATA)) {
    mkdir(DATA);
}