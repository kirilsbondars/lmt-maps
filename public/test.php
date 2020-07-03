<?php

$lines = file("C:\Users\kirilsbo\Desktop\lmt_map_files\Riga_OKK_changed.txt");
$line = $lines[1];

$needle = "\t";
$lastPos = 0;
$positions = array();

while (($lastPos = strpos($line, $needle, $lastPos))!== false) {
    $positions[] = $lastPos;
    $lastPos = $lastPos + strlen($needle);
}

$a = substr($line, $positions[6] + 1, $positions[7] - $positions[6] - 1);
echo $a . "\n";

$b = substr($line, $positions[7] + 1, $positions[8] - $positions[7] - 1);
echo $b . "\n";

