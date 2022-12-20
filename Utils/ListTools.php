<?php
declare(strict_types=1);

namespace Adorosh\Algorithms\Utils;

class ListTools
{
    public static function generateList(int $length = 20, int $from = -100, int $to = 100): \SplDoublyLinkedList
    {
        $result = new \SplDoublyLinkedList();

        foreach (ArrayTools::generateArray($length, $from, $to) as $item) {
            $result->push($item);
        }

        return $result;
    }

    public static function print(\SplDoublyLinkedList $list, string $separator = ', '): void
    {
        $arr = [];
        $list->rewind();

        foreach ($list as $item) {
            $arr[] = $item;
        }

        ArrayTools::print($arr);
    }
}