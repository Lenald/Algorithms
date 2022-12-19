<?php

require '../vendor/autoload.php';

use Adorosh\Algorithms\Utils\ArrayTools;

$arr = ArrayTools::generateArray();
ArrayTools::print($arr);

echo 'WARNING! This algorithm may never stop!' . PHP_EOL;

do {
    $sorted = true;

    for ($i = 1; $i < count($arr); $i++) {
        if ($arr[$i] < $arr[$i - 1]) {
            $sorted = false;

            break;
        }
    }
} while (!$sorted);

ArrayTools::print($arr);
