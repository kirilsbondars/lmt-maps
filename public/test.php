<?php
include_once("../src/initialize.php");

$layers = LayerNew::find_all();

foreach($layers as $layer) {
    echo json_encode($layer);
}

$layer = LayerNew::find_by_id(29);
echo json_encode($layer);
echo $layer->type();