<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use App\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'company' => $faker->domainName,
        'country' => $faker->country,
        'city' => $faker->city,
        'website' => $faker->domainName,
        'social' => $faker->domainName,
        'history' => $faker->text,
        'last_user' => function () {
            return User::inRandomOrder()->first()->id;
        },
        'is_deleted' => $faker->numberBetween(0, 1)
    ];
});
