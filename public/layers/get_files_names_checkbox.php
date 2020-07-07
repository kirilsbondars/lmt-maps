<?php
require_once("../../src/initialize.php");

$layers = Layer::get_all();

if(empty($layers))
    echo '<p style="text-align: center"><em>No uploaded layers</em></p>';

foreach ($layers as $num => $layer) {
    echo '<div class="form-check">
        <input class="form-check-input" type="checkbox" value="'. $layer->id . '" id="' . $layer->id . '">
        <label class="form-check-label" for="' . $layer->id . '">
            ' . $layer->name . '
        </label>
    </div>';
}
