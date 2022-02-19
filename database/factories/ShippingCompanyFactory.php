<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ShippingCompany;
use Faker\Generator as Faker;

$factory->define(ShippingCompany::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->company,
        'active' => $faker->boolean,
        'extra' => $faker->boolean ? $faker->word : null,
    ];
});
