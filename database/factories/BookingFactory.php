<?php

use Faker\Generator as Faker;

$factory->define(App\Booking::class, function (Faker $faker) {
    return [
        'user_id' => factory('App\User')->create(),
        'journey_id' => factory('App\Journey')->create(),
        'pending' => true,
    ];
});
