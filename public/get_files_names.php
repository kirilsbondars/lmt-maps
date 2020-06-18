<?php

if ($handle = opendir('./data')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            echo '<div class="form-check">
                    <input class="form-check-input" type="checkbox" value="'. $entry . '" id="' . $entry . '">
                    <label class="form-check-label" for="' . $entry . '">
                        ' . $entry . '
                    </label>
             </div>';
        }
    }
    closedir($handle);
}