<?php

require '../vendor/autoload.php';

use Adorosh\Algorithms\Utils\ArrayTools;

$arr = range(1, 20);
ArrayTools::print($arr);

for ($l = 0, $r = count($arr) - 1; $l < $r; $l++, $r--) {
    ArrayTools::swap($arr, $l, $r);
}

ArrayTools::print($arr);
