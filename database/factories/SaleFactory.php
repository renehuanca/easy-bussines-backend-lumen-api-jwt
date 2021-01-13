<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use App\Product;
use App\Sale;
use App\Customer;

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

$factory->define(Sale::class, function (Faker $faker) {
    return [
        'quantity' => $faker->numberBetween(100, 200),
        'total' => 0,
        'product_id' => function () {
            return Product::where('is_deleted', 0)->inRandomOrder()->first()->id;
        },
        'customer_id' => function () {
            return Customer::where('is_deleted', 0)->inRandomOrder()->first()->id;
        },
        'last_user' => function () {
            return User::inRandomOrder()->first()->id;
        },
        'is_deleted' => $faker->numberBetween(0, 1)
    ];
});
