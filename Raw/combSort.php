<?php
declare(strict_types=1);

require '../vendor/autoload.php';

use Adorosh\Algorithms\Utils\ArrayTools;

$arr = ArrayTools::generateArray();
ArrayTools::print($arr);

$factor = 1.247;
$offset = 0;

do {
    $sorted = true;

    $l = 0;
    $r = (int)((count($arr) - 1) / ($offset ?: 1));
    $r = ($r - $l < 1) ? $l + 1 : $r;

    for (; $r < count($arr); $l++, $r++) {
        if ($arr[$l] > $arr[$r]) {
            $sorted = false;
            ArrayTools::swap($arr, $l, $r);
        }
    }

    if ($r - $l > 1) {
        $offset += $factor;
    }
} while (!$sorted || $r - $l > 1);

ArrayTools::print($arr);
