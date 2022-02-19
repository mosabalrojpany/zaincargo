<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
        'phone' => $faker->e164PhoneNumber,
        'email' => $faker->email,
        'title' => $faker->realText($faker->numberBetween(32, 120)),
        'content' => $faker->realText($faker->numberBetween(100, 500)),
        'country' => $faker->country,
        'city' => $faker->city,
        'ip' => $faker->ipv4,
        'unread' => $faker->boolean,
    ];
});
