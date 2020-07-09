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
$args['name'] = "Katya's name";
$args['path'] = 'some path';
$args['style'] = '{"color" : "rainbow"}';

$layer = new LayerNew($args);
$result = $layer->create();

if($result) {
    echo $layer->id . " " . $layer->name . " " . $layer->path . " " . $layer->style;
} else {
    //show errors
}