<?php
declare(strict_types=1);

require '../vendor/autoload.php';

use Adorosh\Algorithms\Utils\ArrayTools;

$arr = ArrayTools::generateArray();
ArrayTools::print($arr);

function mergeSort(array &$arr, int $start = 0, int $end = -1): void
{
    if ($end === -1) {
        $end = count($arr) - 1;
    }

    if ($start >= $end) {
        return;
    }

    $splitPoint = (int)(($start + $end) / 2);

    mergeSort($arr, $start, $splitPoint);
    mergeSort($arr, $splitPoint + 1, $end);

    merge($arr, $start, $splitPoint, $end);
}

function merge(array &$arr, int $start, int $middle, int $end): void
{
    $buffer = [];
    
    $l = $start;
    $r = $middle + 1;
    
    while ($l <= $middle && $r <= $end) {
        if ($arr[$l] < $arr[$r]) {
            $buffer[] = $arr[$l++];
        } else {
            $buffer[] = $arr[$r++];
        }
    }

    while ($l <= $middle) {
        $buffer[] = $arr[$l++];
    }

    while ($r <= $end) {
        $buffer[] = $arr[$r++];
    }

    for ($i = 0; $i < count($buffer); $i++) {
        $arr[$start + $i] = $buffer[$i];
    }
}

mergeSort($arr);

ArrayTools::print($arr);
