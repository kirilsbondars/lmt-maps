<?php
require_once("../../src/initialize.php");

if(!isset($_POST['ids'])) {
    exit("Error: no ID inputted");
}
$json = $_POST["ids"];
$ids = json_decode($json);

$ids_length = count($ids);
if($ids_length == 0) {
    exit("No IDs in array");
} elseif ($ids_length == 1) {
    deleteLayer($ids[0]);
} else {
    foreach ($ids as $id) {
        deleteLayer($id);
    }
}

echo true;


// Functions
function deleteLayer($id) {
    $layer = Layer::find_by_id($id);
    if($layer == false) {
        exit("Error: no such ID in DB");
    }

    $result = $layer->delete();
    if($result == false) {
        exit("Error: file was not deleted from DB");
    }

    if(file_exists($layer->path)) {
        unlink($layer->path);
    }
}