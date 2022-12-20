<?php
declare(strict_types=1);

namespace Adorosh\Algorithms\Utils;

class ArrayTools
{
    public static function generateArray(int $length = 20, int $from = -100, int $to = 100): array
    {
        $result = [];

        for ($i = 0; $i < $length; $i++) {
            $result[] = random_int($from, $to);
        }

        return $result;
    }

    public static function print(array $values, string $separator = ', '): void
    {
        echo implode($separator, $values) . PHP_EOL;
    }

    public static function swap(array &$arr, int $l, int $r): void
    {
        $tmp = $arr[$l];
        $arr[$l] = $arr[$r];
        $arr[$r] = $tmp;
    }
}