<?php

use Faker\Generator as Faker;

$factory->define(App\Journey::class, function (Faker $faker) {

    $cities = [
        'Lille', 'Valenciennes', 'Maubeuge', 'Lens', 'Vincennes', 'Nîmes', 'Besançon', 'Arles',
        'Paris', 'Lyon', 'Bordeaux', 'Castres', 'Verdun', 'Brest', 'Fourmies',
    ];

    return [
        'user_id' => factory(\App\User::class),
        'departure' => $cities[rand(0, count($cities) - 1)],
        'arrival' => $cities[rand(0, count($cities) - 1)],
        'seats' => rand(1, 7),
        'departure_datetime' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        'arrival_datetime' =>  \Carbon\Carbon::now()->addDay()->minute(rand(0, 59))->hours(rand(1, 24))->format('Y-m-d H:i:s'),
        'allows_pets' => rand(0, 1),
        'allows_smoking' => rand(0, 1),
        'driver_comment' => $faker->paragraph('1'),
    ];
});
