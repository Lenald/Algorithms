<?php
$a = 0;
$b = 1;

while (true) {
    $b = $a + $b;
    $a = $b - $a;

    //Cast scientific notation (1.3069892237634E+308) into human-readable and remove thousands separator
    echo number_format($b, 0, '.', ' ') . PHP_EOL;

    //iteration 1476 reaches the double memory limit of 8 bytes and the number is being transformed to infinity
    if (is_infinite($b)) {
        break;
    }
}
