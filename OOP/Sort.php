<?php
declare(strict_types=1);

namespace Adorosh\Algorithms\OOP;

use Adorosh\Algorithms\Utils\ArrayTools;

class Sort
{
    /**
     * @see https://upload.wikimedia.org/wikipedia/commons/c/c8/Bubble-sort-example-300px.gif
     */
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

    /**
     * @see https://upload.wikimedia.org/wikipedia/commons/9/94/Selection-Sort-Animation.gif
     */
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

    /**
     * @see https://upload.wikimedia.org/wikipedia/commons/0/0f/Insertion-sort-example-300px.gif
     */
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

    /**
     * @see https://upload.wikimedia.org/wikipedia/commons/e/ef/Sorting_shaker_sort_anim.gif
     */
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
                if ($arr[$r] > $arr[$l]) {
                    $sorted = false;
                    ArrayTools::swap($arr, $l, $r);
                }
            }
            $offsetL++;
        } while (!$sorted);

        return $arr;
    }

    /**
     * @see https://upload.wikimedia.org/wikipedia/commons/9/9c/Quicksort-example.gif
     */
    public static function quickSort(array $arr): array
    {
        self::quickSortHoare($arr, 0, count($arr) - 1);

        return $arr;
    }

    /**
     * @see https://en.wikipedia.org/wiki/Quicksort#Hoare_partition_scheme
     */
    public static function quickSortHoare(array &$arr, int $start = 0, int $end = -1)
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