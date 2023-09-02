<?php

use Faker\Generator as Faker;
use App\ValueList;

$factory->define(ValueList::class, function (Faker $faker) {
    return [
        'title' => 'title',
        'description' => 'description',
        'code' => 'code',
        'created_by_id' => 1
    ];
});
