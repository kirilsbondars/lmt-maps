<?php
require_once("../../src/initialize.php");

check_POST_request();

$postJSON = file_get_contents('php://input');
$post = json_decode($postJSON, true);

$possible_attr = array("id", "name", "strokeColor", "strokeWidth", "pointColor", "pointRadius");
$post_attr = array();

foreach($post as $attr => $val) {
    array_push($post_attr, $attr);

    if(empty($val)) //check if all value are with data
        exit("Attribute value can't be empty");
}

foreach($possible_attr as $attr) {
    if (!in_array($attr, $post_attr)) //check if all needed attributes were submitted
        exit("Not all needed attributes were submitted");
}

$layer = new Layer();
$layer->id = $post["id"];
$layer->name = $post["name"];
$layer->setCustomStyle($post["strokeColor"], $post["strokeWidth"], $post["pointColor"], $post["pointRadius"]);
echo $layer->change();




