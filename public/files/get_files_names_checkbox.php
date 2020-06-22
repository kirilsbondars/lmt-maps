<?php
require_once("../../src/initialize.php");

$files_names = get_files_names(DATA);

foreach ($files_names as $value) {
    echo '<div class="form-check">
        <input class="form-check-input" type="checkbox" value="'. $value . '" id="' . $value . '">
        <label class="form-check-label" for="' . $value . '">
            ' . $value . '
        </label>
    </div>';
}