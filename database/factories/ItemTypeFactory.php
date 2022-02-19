<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\ItemType;
use Faker\Generator as Faker;

$factory->define(ItemType::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'active' => $faker->boolean,
        'extra' => $faker->realText(rand(10, 100)),
    ];
});
