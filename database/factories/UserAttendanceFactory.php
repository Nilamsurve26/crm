<?php

use App\UserAttendance;
use Faker\Generator as Faker;

$factory->define(UserAttendance::class, function (Faker $faker) {
    return [
        'user_id'=>1,
        'latitude'=> 'latitude',
        'longitude'=>'longitude',
        'date'=>'date',
        'ticket_id'=>1,
    ];
});
