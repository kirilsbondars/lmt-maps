<?php
require_once("../../src/initialize.php");

$layers = Layer::get_all();

foreach ($layers as $num => $layer) {
    echo '<tr>';
    echo '<td>' . $layer["name"] . '</td>';
    echo '<td>' . $layer["style"] .'</td>';
    echo '<td class="actionsColumn">';
    echo '<button class="btn edit" id="' . $layer["id"] .'" value="' . $layer["id"] .'" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil-square-o fa-lg green"></i></button>';
    echo '<button class="btn delete" id="' . $layer["id"] .'" value="' . $layer["id"] .'"><i class="fa fa-times fa-lg red" aria-hidden="true"></i></button>';
    echo '</td>';
}
