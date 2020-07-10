<?php
include_once("../src/initialize.php");

// Show all layers
$layers = Layer::find_all();

foreach($layers as $layer) {
    echo json_encode($layer);
}

// Find layer by id
$layer = Layer::find_by_id(47);
echo json_encode($layer);
echo $layer->type();


// Data
// <input name=layer[name]>
// <input name=layer[path]>
// in php | $args = $_POST['layer']; json

$args = [];
$args['name'] = 'scs';
$args['path'] = 'scsc';
$args['style'] = '{"111" : "111"}';

// Create
$layer = new Layer($args);
$result = $layer->save();

if($result) {
    echo $layer->id . " " . $layer->name . " " . $layer->path . " " . $layer->style;
} else {
    echo json_encode($layer->errors);
}

// Update
$layers = Layer::find_by_id(47);
if($layers == false) {
    echo "error no id";
}

$layers->merge_attributes($args);
$result = $layers->save();

if($result == true) {
    echo "layer updated";
}


// DELETE
$layers = Layer::find_by_id(47);
if($layers == false) {
    echo "error no id";
}

$result = $layers->delete();
echo $result;
