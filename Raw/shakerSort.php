<?php

require '../vendor/autoload.php';

use Adorosh\Algorithms\Utils\ArrayTools;

$arr = ArrayTools::generateArray();
ArrayTools::print($arr);

$offsetL = $offsetR = 0;

do {
    $sorted = true;

    for (
        $l = 0 + $offsetL, $r = 1 + $offsetL;
        $r < count($arr) - $offsetR;
        $l++, $r++
    ) {
        if ($arr[$l] > $arr[$r]) {
            $sorted = false;
            ArrayTools::swap($arr, $l, $r);
        }
    }
    $offsetR++;

    for (
        $l = count($arr) - $offsetR - 2, $r = count($arr) - $offsetR - 1;
        $l > $offsetL;
        $l--, $r--
    ) {
        if ($arr[$r] > $arr[$l]) {
            $sorted = false;
            ArrayTools::swap($arr, $l, $r);
        }
    }
    $offsetL++;
} while (!$sorted);

ArrayTools::print($arr);
