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

// Data
// <input name=layer[name]>
// <input name=layer[path]>
// in php | $args = $_POST['layer']; json

$args = [];
$args['name'] = "222222";
$args['path'] = '111111';
$args['style'] = '{"111" : "111"}';

// Create
$layer = new LayerNew($args);
$result = $layer->save();

if($result) {
    echo $layer->id . " " . $layer->name . " " . $layer->path . " " . $layer->style;
} else {
    //show errors
}

// Update
$layers = LayerNew::find_by_id(91);
if($layers == false) {
    echo "error no id";
}

$layers->merge_attributes($args);
$result = $layers->save();

if($result == true) {
    echo "layer updated";
}