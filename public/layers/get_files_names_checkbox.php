<?php
require_once("../../src/initialize.php");

$layers = Layer::get_all();

foreach ($layers as $num => $layer) {
    echo '<div class="form-check">
        <input class="form-check-input" type="checkbox" value="'. $layer->id . '" id="' . $layer->id . '">
        <label class="form-check-label" for="' . $layer->id . '">
            ' . $layer->name . '
        </label>
    </div>';
}
