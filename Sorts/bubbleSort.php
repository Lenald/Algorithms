<?php

require '../vendor/autoload.php';

use Adorosh\Algorithms\Utils\ArrayTools;

$arr = ArrayTools::generateArray();
ArrayTools::print($arr);

$offset = 0;

do {
    $sorted = true;

    for ($l = 0, $r = 1; $r < count($arr) - $offset; $l++, $r++) {
        if ($arr[$l] > $arr[$r]) {
            $sorted = false;
            ArrayTools::swap($arr, $l, $r);
        }
    }

    $offset++;
} while (!$sorted);

ArrayTools::print($arr);
