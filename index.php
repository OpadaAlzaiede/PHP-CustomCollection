<?php

require_once './CustomCollection.php';

$collection = CustomCollection::make([1, 2, 3]);
$collection[3] = 12;
$collection[] = 13;
$collection['key'] = 14;

$newCollection = $collection->map(function($item) {

    return $item * 2;
})
->filter(function($item) {

    return $item > 5;
});

var_dump($newCollection);


$collection1 = CustomCollection::make([
    ['a' => 1],
    ['a' => 2]
]);

$sum = $collection1->sum('a');

var_dump($sum);