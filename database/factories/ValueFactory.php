<?php

use Faker\Generator as Faker;
use App\Value;

$factory->define(Value::class, function (Faker $faker) {
    return [
        
'title'=>'title',
'sub_title'=>'sub_title',
'description'=>'description',
'code'=>'code',
'created_by_id' => 1

    ];
});
