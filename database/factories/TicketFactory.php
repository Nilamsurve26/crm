<?php

use App\Ticket;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {
    return [
        'title' => 'title',
        'description' => 'description',
        'issued_type_id' => 1,
        'status_type_id' => 1,
        'image_path_1' => 'image_path_1',
        'image_path_2' => 'image_path_2',
        'image_path_3' => 'image_path_3',
        'image_path_4' => 'image_path_4',
        'video_path' => 'video_path',
        'created_by_id' => 1,
        'assigned_to_id' => 1,

    ];
});
