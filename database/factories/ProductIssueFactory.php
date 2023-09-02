<?php

use App\ProductIssue;
use Faker\Generator as Faker;

$factory->define(ProductIssue::class, function (Faker $faker) {
    return [
        'product_id' => 2,
        'description' => 'description',
        'name' => 'name'
    ];
});
