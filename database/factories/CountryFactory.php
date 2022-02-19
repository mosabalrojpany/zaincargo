<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Country;
use Faker\Generator as Faker;

$factory->define(Country::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->country,
        'logo' => $faker->image(public_path('storage/images/countries'), 120, 60, 'business', false),
        'active' => $faker->boolean,
        'extra' => $faker->realText(rand(10, 75)),
    ];
});
