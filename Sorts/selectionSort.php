<?php

require '../vendor/autoload.php';

use Adorosh\Algorithms\Utils\ArrayTools;

$arr = ArrayTools::generateArray();
ArrayTools::print($arr);

for ($lastSorted = 0; $lastSorted < count($arr) - 1; $lastSorted++) {
    $minIndex = $lastSorted;

    for ($current = 1 + $lastSorted; $current < count($arr); $current++) {
        if ($arr[$current] < $arr[$minIndex]) {
            $minIndex = $current;
        }
    }

    if ($arr[$lastSorted] > $arr[$minIndex]) {
        ArrayTools::swap($arr, $lastSorted, $minIndex);
    }
}

ArrayTools::print($arr);
