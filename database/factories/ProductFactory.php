<?php

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'created_by_id' => 1,
        'imagepath_1' => 'imagepath_1',
        'imagepath_2' => 'imagepath_2',
        'imagepath_3' => 'imagepath_3',
        'imagepath_4' =>  'imagepath_4',
        'name' => 'name',
        'short_description' => 'short_description',
        'description' => 'description',
        'brand_id' => 1,
        'barcode' => 'barcode',
    ];
});
