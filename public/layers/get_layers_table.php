<?php
require_once("../../src/initialize.php");

$layers = Layer::get_all();

foreach ($layers as $layer) {
    $layer->print_table_row();
}
