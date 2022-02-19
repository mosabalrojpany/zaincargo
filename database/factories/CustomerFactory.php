<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {

    $state = $faker->numberBetween(1, 3);

    $customerCodeStartsWith = get_customer_code_starts_with();

    /* Start image */
    if ($faker->boolean) {
        $image_path = public_path('storage/images/customers/');
        $img_name = $faker->image($image_path, 240, 240, 'people', false);
        Image::make($image_path . $img_name)->resize(150, 150)->save($image_path . 'avatar/' . $img_name);
    } else {
        $img_name = null;
    }
    /* ENd image */

    $created_at = $faker->dateTimeBetween('-5 years', '-1 days');
    $activated_at = $state > 1 ? $faker->dateTimeBetween($created_at) : null;
    $last_access = $state == 3 ? $faker->dateTimeBetween($activated_at) : null;

    return [
        'code' => $activated_at ? $customerCodeStartsWith . (1 + Customer::max(DB::Raw("CONVERT(REPLACE(code,'$customerCodeStartsWith','') , UNSIGNED)"))) : null,
        'name' => $faker->name,
        'phone' => $faker->unique()->e164PhoneNumber,
        'address' => $faker->address,
        'email' => $faker->unique()->email,
        'img' => $img_name,
        'verification_file' => $faker->image(storage_path('app/customers/verifications'), 120, 60, 'business', false),
        'password' => bcrypt('testing'), // password
        'receive_in' => App\Models\ReceivingPlace::inRandomOrder()->first()->id,
        'state' => $state,
        'extra' => $faker->realText(rand(10, 200)),
        'created_at' => $created_at,
        'activated_at' => $activated_at,
        'last_access' => $last_access,
    ];
});

$factory->state(Customer::class, 'new', function (Faker $faker) {
    return [
        'code' => null,
        'state' => 1,
        'extra' => null,
        'created_at' => $faker->dateTimeBetween('-6 months', '-1 hours'),
        'activated_at' => null,
        'last_access' => null,
    ];
});
