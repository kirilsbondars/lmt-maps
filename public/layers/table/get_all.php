<?php
require_once("../../../src/initialize.php");

$layers = Layer::find_all();

if(empty($layers))
    echo '<tr>
            <td colspan="4" style="text-align: center" id="0">No uploaded layers</td>
          </tr>';

foreach ($layers as $layer) {
    include "get_row.php";
}
