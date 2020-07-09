<?php
include_once("../src/initialize.php");

//$layers = LayerNew::find_all();
//
//foreach($layers as $layer) {
//    echo json_encode($layer);
//}
//
//$layer = LayerNew::find_by_id(47);
//echo json_encode($layer);
//echo $layer->type();
//
$args = [];
$args['name'] = "changed info";
$args['path'] = 'changed';
$args['style'] = '{"color" : "change"}';

// Create
//$layer = new LayerNew($args);
//$result = $layer->create();
//
//if($result) {
//    echo $layer->id . " " . $layer->name . " " . $layer->path . " " . $layer->style;
//} else {
//    //show errors
//}

// Update
$layers = LayerNew::find_by_id(1);
if($layers == false) {
    echo "error no id";
}

$layers->merge_attributes($args);
$result = $layers->update();

if($result == true) {
    echo "layer updated";
}