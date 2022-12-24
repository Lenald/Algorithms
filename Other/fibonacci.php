<?php
$a = 0;
$b = 1;

echo $a . PHP_EOL . $b . PHP_EOL;

while (!is_infinite($a)) {
    $b = $a + $b;
    $a = $b - $a;

    //Cast scientific notation (1.3069892237634E+308) into human-readable and remove thousands separator
    echo number_format($b, 0, '.', ' ') . PHP_EOL;
}

function printSequenceRecursive(int $a = 0, int $b = 1): void
{
    if (is_infinite($a)) {
        return;
    }

    if ($a === 0) {
        echo $a . PHP_EOL;
    }

    echo number_format($b, 0, '.', ' ') . PHP_EOL;

    printSequenceRecursive($b, $a + $b);
}

printSequenceRecursive();
