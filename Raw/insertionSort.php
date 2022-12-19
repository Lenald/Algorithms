<?php

require '../vendor/autoload.php';

use Adorosh\Algorithms\Utils\ArrayTools;

$arr = ArrayTools::generateArray();
ArrayTools::print($arr);

for ($i = 1; $i < count($arr); $i++) {
    $current = $arr[$i];
    $offset = 1;

    while ($i - $offset >= 0 && $current < $arr[$i - $offset]) {
        $arr[$i - $offset + 1] = $arr[$i - $offset];
        $arr[$i - $offset] = $current;

        $offset++;
    }
}

ArrayTools::print($arr);
