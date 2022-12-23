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

    public static function print(array $values, string $separator = ', ', bool $diagram = false): void
    {
        if (!$diagram) {
            echo implode($separator, $values) . PHP_EOL;
        } else {
            foreach ($values as $item) {
                echo str_repeat('#', $item) . $separator;
            }
        }
    }

    public static function swap(array &$arr, int $l, int $r): void
    {
        $tmp = $arr[$l];
        $arr[$l] = $arr[$r];
        $arr[$r] = $tmp;
    }
}