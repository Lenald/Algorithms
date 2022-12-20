<?php

require '../vendor/autoload.php';

use Adorosh\Algorithms\Utils\ArrayTools;
use Adorosh\Algorithms\Utils\ListTools;

$arr = ArrayTools::generateArray();
ArrayTools::print($arr);

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

ArrayTools::print(array_slice($arr, 0, $lastSorted + 1));

$list = ListTools::generateList();
ListTools::print($list);

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

ListTools::print($list);
