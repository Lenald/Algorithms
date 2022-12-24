<?php

require '../vendor/autoload.php';

use Adorosh\Algorithms\Utils\ArrayTools;

$arr = ArrayTools::generateArray();
ArrayTools::print($arr);

function processHoarePartition(array &$arr, int $l, int $r): int
{
    $pivot = $arr[floor(($l + $r) / 2)];

    while ($l <= $r) {
        while ($arr[$l] < $pivot) $l++;
        while ($arr[$r] > $pivot) $r--;

        if ($l <= $r) {
            ArrayTools::swap($arr, $l, $r);
            $l++;
            $r--;
        }
    }

    return $l;
}

function quickSortHoare(array &$arr, int $start, int $end): void
{
    if ($start >= $end) {
        return;
    }

    $rightPartitionStart = processHoarePartition($arr, $start, $end);
    quickSortHoare($arr, $start, $rightPartitionStart - 1);
    quickSortHoare($arr, $rightPartitionStart, $end);
}

quickSortHoare($arr, 0, count($arr) - 1);

ArrayTools::print($arr);
