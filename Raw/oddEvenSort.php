<?php
declare(strict_types=1);

require '../vendor/autoload.php';

use Adorosh\Algorithms\Utils\ArrayTools;

$arr = ArrayTools::generateArray();
ArrayTools::print($arr);

$start = 0;

do {
    $sorted = true;

    for ($l = $start, $r = $start + 1; $l < count($arr) && $r < count($arr); $l += 2, $r += 2) {
        if ($arr[$l] > $arr[$r]) {
            $sorted = false;
            ArrayTools::swap($arr, $l, $r);
        }
    }

    $start = $start ? 0 : 1;
} while (!$sorted);

ArrayTools::print($arr);
