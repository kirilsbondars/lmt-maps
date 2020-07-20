<?php
require_once("../../../src/initialize.php");

$layers = Layer::find_all();

if(empty($layers))
    echo '<tr>
            <td colspan="3" style="text-align: center" id="0">No uploaded layers</td>
          </tr>';

foreach ($layers as $layer) {
    $id = $layer->id;
    $name = $layer->name;
    $style = json_decode($layer->style, true);
    $strokeColor = $style["stroke"]["color"];
    $circleColor = $style["circle"]["fill"]["color"];

    include "table_row.php";
}