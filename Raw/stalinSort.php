<?php

require '../vendor/autoload.php';

use Adorosh\Algorithms\Utils\ArrayTools;

function findPrev(array $arr, int $i): int
{
    return $arr[$i] ?? findPrev($arr, $i - 1);
}

$arr = ArrayTools::generateArray();
ArrayTools::print($arr);

$lastId = count($arr) - 1;

for ($i = 1; $i < $lastId; $i++) {
    if ($arr[$i] < findPrev($arr, $i - 1)) {
        unset($arr[$i]);
    }
}

ArrayTools::print($arr);
