<?php
$a = 0;
$b = 1;

echo $a . PHP_EOL . $b . PHP_EOL;

while (!is_infinite($this->a)) {
    $b = $a + $b;
    $a = $b - $a;

    //Cast scientific notation (1.3069892237634E+308) into human-readable and remove thousands separator
    echo number_format($b, 0, '.', ' ') . PHP_EOL;
}
