<?php
declare(strict_types=1);

namespace Adorosh\Algorithms\OOP;

class Sort
{
    /**
     * @see https://upload.wikimedia.org/wikipedia/commons/c/c8/Bubble-sort-example-300px.gif
     */
    public static function bubble(array $arr): array
    {
        $offset = 0;

        do {
            $sorted = true;

            for ($l = 0, $r = 1; $r < count($arr) - $offset; $l++, $r++) {
                if ($arr[$l] > $arr[$r]) {
                    $sorted = false;
                    self::swap($arr, $l, $r);
                }
            }

            $offset++;
        } while (!$sorted);

        return $arr;
    }

    /**
     * @see https://upload.wikimedia.org/wikipedia/commons/9/94/Selection-Sort-Animation.gif
     */
    public static function selection(array $arr): array
    {
        for ($lastSorted = 0; $lastSorted < count($arr) - 1; $lastSorted++) {
            $minIndex = $lastSorted;

            for ($current = 1 + $lastSorted; $current < count($arr); $current++) {
                if ($arr[$current] < $arr[$minIndex]) {
                    $minIndex = $current;
                }
            }

            if ($arr[$lastSorted] > $arr[$minIndex]) {
                self::swap($arr, $lastSorted, $minIndex);
            }
        }

        return $arr;
    }

    /**
     * @see https://upload.wikimedia.org/wikipedia/commons/0/0f/Insertion-sort-example-300px.gif
     */
    public static function insertion(array $arr): array
    {
        for ($i = 1; $i < count($arr); $i++) {
            $current = $arr[$i];
            $offset = 1;

            while ($i - $offset >= 0 && $current < $arr[$i - $offset]) {
                $arr[$i - $offset + 1] = $arr[$i - $offset];
                $arr[$i - $offset] = $current;

                $offset++;
            }
        }

        return $arr;
    }

    /**
     * @see https://upload.wikimedia.org/wikipedia/commons/e/ef/Sorting_shaker_sort_anim.gif
     */
    public static function shaker(array $arr): array
    {
        $offsetL = $offsetR = 0;

        do {
            $sorted = true;

            for (
                $l = 0 + $offsetL, $r = 1 + $offsetL;
                $r < count($arr) - $offsetR;
                $l++, $r++
            ) {
                if ($arr[$l] > $arr[$r]) {
                    $sorted = false;
                    self::swap($arr, $l, $r);
                }
            }
            $offsetR++;

            for (
                $l = count($arr) - $offsetR - 2, $r = count($arr) - $offsetR - 1;
                $l > $offsetL;
                $l--, $r--
            ) {
                if ($arr[$r] > $arr[$l]) {
                    $sorted = false;
                    self::swap($arr, $l, $r);
                }
            }
            $offsetL++;
        } while (!$sorted);

        return $arr;
    }

    private static function swap(array &$arr, int $l, int $r): void
    {
        $tmp = $arr[$l];
        $arr[$l] = $arr[$r];
        $arr[$r] = $tmp;
    }

    //Jokes

    /**
     * @see https://i.redd.it/x9triplll1v11.jpg
     */
    public static function stalin(array $arr): array
    {
        $findPrev = function (array $arr, int $i) use (&$findPrev): int
        {
            return $arr[$i] ?? $findPrev($arr, $i - 1);
        };

        $lastId = count($arr) - 1;

        for ($i = 1; $i < $lastId; $i++) {
            if ($arr[$i] < $findPrev($arr, $i - 1)) {
                unset($arr[$i]);
            }
        }

        return array_values($arr);
    }

    /**
     * @see https://i.redd.it/4x8k96l6snq21.png
     */
    public static function waitingForMiracle(array $arr): array
    {
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

        return $arr;
    }
}