<?php
declare(strict_types=1);

namespace Adorosh\Algorithms\OOP;

use Adorosh\Algorithms\Utils\ArrayTools;

class Sort
{
    public static function bubbleSort(array $arr): array
    {
        $offset = 0;

        do {
            $sorted = true;

            for ($l = 0, $r = 1; $r < count($arr) - $offset; $l++, $r++) {
                if ($arr[$l] > $arr[$r]) {
                    $sorted = false;
                    ArrayTools::swap($arr, $l, $r);
                }
            }

            $offset++;
        } while (!$sorted);

        return $arr;
    }

    public static function selectionSort(array $arr): array
    {
        for ($lastSorted = 0; $lastSorted < count($arr) - 1; $lastSorted++) {
            $minIndex = $lastSorted;

            for ($current = 1 + $lastSorted; $current < count($arr); $current++) {
                if ($arr[$current] < $arr[$minIndex]) {
                    $minIndex = $current;
                }
            }

            if ($arr[$lastSorted] > $arr[$minIndex]) {
                ArrayTools::swap($arr, $lastSorted, $minIndex);
            }
        }

        return $arr;
    }

    public static function insertionSort(array $arr): array
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

    public static function shakerSort(array $arr): array
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
                    ArrayTools::swap($arr, $l, $r);
                }
            }
            $offsetR++;

            for (
                $l = count($arr) - $offsetR - 2, $r = count($arr) - $offsetR - 1;
                $l > $offsetL;
                $l--, $r--
            ) {
                if ($arr[$r] < $arr[$l]) {
                    $sorted = false;
                    ArrayTools::swap($arr, $l, $r);
                }
            }
            $offsetL++;
        } while (!$sorted);

        return $arr;
    }

    public static function quickSort(array $arr, string $algorithm = 'Hoare'): array
    {
        switch ($algorithm) {
            case 'Lomuto':
                $method = 'quickSortLomuto';
                break;

            case 'Hoare':
            default:
                $method = 'quickSortHoare';
        }

        self::$method($arr, 0, count($arr) - 1);

        return $arr;
    }

    public static function quickSortHoare(array &$arr, int $start = 0, int $end = -1): void
    {
        if ($start >= $end) {
            return;
        }

        $l = $start;
        $r = $end;

        $pivot = $arr[floor(($l + $r) / 2)];

        while ($l <= $r) {
            while ($arr[$l] < $pivot) $l++;
            while ($arr[$r] > $pivot) $r--;

            if ($l <= $r) {
                ArrayTools::swap($arr, $l, $r);
                $l++;
                $r--;
            }
        }

        self::quickSortHoare($arr, $start, $l - 1);
        self::quickSortHoare($arr, $l, $end);
    }

    public static function quickSortLomuto(array &$arr, int $start, int $end): void
    {
        if ($start >= $end) {
            return;
        }

        $l = $start;
        $r = $end;

        for ($current = $l; $current < $r; $current++) {
            if ($arr[$current] <= $arr[$r]) {
                ArrayTools::swap($arr, $l, $current);
                $l++;
            }
        }

        ArrayTools::swap($arr, $l, $r);

        self::quickSortLomuto($arr, $start, $l - 1);
        self::quickSortLomuto($arr, $l + 1, $end);
    }

    public static function mergeSort(array &$arr, int $start = 0, int $end = -1) {
        if ($end === -1) {
            $end = count($arr) - 1;
        }

        if ($start >= $end) {
            return;
        }

        $splitPoint = (int)(($start + $end) / 2);

        self::mergeSort($arr, $start, $splitPoint);
        self::mergeSort($arr, $splitPoint + 1, $end);

        $buffer = [];

        $l = $start;
        $r = $splitPoint + 1;

        while ($l <= $splitPoint && $r <= $end) {
            if ($arr[$l] < $arr[$r]) {
                $buffer[] = $arr[$l++];
            } else {
                $buffer[] = $arr[$r++];
            }
        }

        while ($l <= $splitPoint) {
            $buffer[] = $arr[$l++];
        }

        while ($r <= $end) {
            $buffer[] = $arr[$r++];
        }

        for ($i = 0; $i < count($buffer); $i++) {
            $arr[$start + $i] = $buffer[$i];
        }
    }

    //Jokes

    /**
     * @see https://i.redd.it/x9triplll1v11.jpg
     */
    public static function stalinSortArray(array $arr): array
    {
        $lastSorted = 0;

        for ($current = 1; $current < count($arr); $current++) {
            if ($arr[$current] < $arr[$lastSorted]) {
                $arr[$current] = null;
            } else {
                if ($current > ($lastSorted + 1)) {
                    $arr[$lastSorted + 1] = $arr[$current];
                }

                $lastSorted++;
            }
        }

        return array_slice($arr, 0, $lastSorted + 1);
    }

    public static function stalinSortList(\SplDoublyLinkedList $list): \SplDoublyLinkedList
    {
        $list->rewind();
        $prev = $list->current();
        $list->next();

        while ($list->valid()) {
            if ($list->current() < $prev) {
                $toDelete = $list->key();
                $list->prev();
                $list->offsetUnset($toDelete);
            } else {
                $prev = $list->current();
            }

            $list->next();
        }

        $list->rewind();

        return $list;
    }

    /**
     * @see https://i.redd.it/4x8k96l6snq21.png
     */
    public static function waitingForMiracleSort(array $arr): array
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