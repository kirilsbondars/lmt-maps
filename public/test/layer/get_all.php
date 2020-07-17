<?php
require_once("../../../src/initialize.php");

$layers = Layer::find_all();
$layers_arr = array();
$layer_sorted = array();

foreach ($layers as $i => $layer) {
    $layers_arr[$i] = $layer->getPublicDataArray();
}

//foreach ($layers_arr as $i => $layer) {
//    $cat = $layer["category"];
//    $layer_sorted[$cat] =
//}


echo json_encode($layers_arr);