<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    $city = App\Models\City::inRandomOrder()->first();
    return [
        'name' => $faker->unique()->name,
        'address1' => $faker->secondaryAddress,
        'address2' => $faker->streetAddress,
        'country_id' => $city->country_id,
        'city_id' => $city->id,
        'state' => $faker->city,
        'phone' => $faker->phoneNumber,
        'phone2' => $faker->boolean ? $faker->phoneNumber : null,
        'phone3' => $faker->boolean ? $faker->phoneNumber : null,
        'zip' => $faker->postcode,
        'extra' => $faker->boolean ? $faker->address : null,
        'type' => $faker->numberBetween(1, 2),
        'active' => $faker->boolean,
    ];
});
