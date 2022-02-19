<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AddressPrice;
use Faker\Generator as Faker;

$factory->define(AddressPrice::class, function (Faker $faker) {
    $from = $faker->randomFloat(3, 0, 10);
    return [
        'from' => $from,
        'to' => $faker->randomFloat(3, $from, 10),
        'price' => $faker->randomFloat(3, 1, 100),
        'description' => $faker->word,
        'address_id' => $faker->numberBetween(1, 5),
    ];
});
