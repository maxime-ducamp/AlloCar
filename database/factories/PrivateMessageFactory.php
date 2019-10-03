<?php

use Faker\Generator as Faker;

$factory->define(App\PrivateMessage::class, function (Faker $faker) {
    return [
        'from_id' => factory('App\User'),
        'to_id' => factory('App\User'),
        'subject' => $faker->sentence,
        'body' => $faker->paragraph
    ];
});
