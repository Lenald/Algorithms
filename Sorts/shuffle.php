<?php

require '../vendor/autoload.php';

use Adorosh\Algorithms\Utils\ArrayTools;

$arr = range(1, 20);
ArrayTools::print($arr);

$last = count($arr) - 1;

for ($i = 0; $i <= $last; $i++) {
    ArrayTools::swap($arr, $i, random_int(0, $last));
}

ArrayTools::print($arr);
