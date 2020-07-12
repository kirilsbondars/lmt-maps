<?php
require_once("../../src/initialize.php");

$layers = Layer::find_all();

if(empty($layers))
    echo '<p style="text-align: center"><em>No uploaded layers</em></p>';

foreach ($layers as $layer) {
    $id = $layer->id;
    $name = $layer->name;
    $style = json_decode($layer->style, true);
    $strokeColor = $style["stroke"]["color"];
    $circleColor = $style["circle"]["fill"]["color"];

    include "layer_row.php";
}
