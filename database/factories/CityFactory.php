<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\City;
use Faker\Generator as Faker;

$factory->define(City::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->cityName,
        'active' => $faker->boolean,
        'extra' => $faker->realText(rand(10, 50)),
        'country_id' => $faker->numberBetween(1, 5),
    ];
});
