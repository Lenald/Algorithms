<?php

require '../vendor/autoload.php';

use Adorosh\Algorithms\Utils\ArrayTools;

$arr = ArrayTools::generateArray();
ArrayTools::print($arr);

function processLomutoPartition(array &$arr, int $l, int $r): int
{
    for ($current = $l; $current < $r; $current++) {
        if ($arr[$current] <= $arr[$r]) {
            ArrayTools::swap($arr, $l, $current);
            $l++;
        }
    }

    ArrayTools::swap($arr, $l, $r);

    return $l;
}

function quickSortLomuto(array &$arr, int $start, int $end): void
{
    if ($start >= $end) {
        return;
    }

    $rightPartitionStart = processLomutoPartition($arr, $start, $end);
    quickSortLomuto($arr, $start, $rightPartitionStart - 1);
    quickSortLomuto($arr, $rightPartitionStart + 1, $end);
}

quickSortLomuto($arr, 0, count($arr) - 1);

ArrayTools::print($arr);
