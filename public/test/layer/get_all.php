<?php
require_once("../../../src/initialize.php");

$layers = Layer::find_all();
$layers_arr = array();

foreach ($layers as $i => $layer) {
    echo $layer->style;
    //$layers_arr[$i] = $layer->getPublicDataArray();
}

//echo json_encode($layers_arr);