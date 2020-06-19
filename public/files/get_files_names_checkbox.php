<?php
require_once("../../src/initialize.php");
require_once(ROOT . "/src/get_files_names.php");

$files_names = get_files_names();

foreach ($files_names as $value) {
    echo '<div class="form-check">
        <input class="form-check-input" type="checkbox" value="'. $value . '" id="' . $value . '">
        <label class="form-check-label" for="' . $value . '">
            ' . $value . '
        </label>
    </div>';
}