<?php
require_once("../../../src/initialize.php");

$layers = Layer::find_all();

if(empty($layers))
    echo '<p style="text-align: center"><em>No uploaded layers</em></p>';

foreach ($layers as $layer) {
    include "get_row.php";
}
