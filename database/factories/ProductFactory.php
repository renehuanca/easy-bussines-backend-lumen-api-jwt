<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use App\Product;
use App\Categorie;

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

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'quantity' => $faker->numberBetween(1, 20),
        'unit_price' => $faker->numberBetween(100, 200),
        'total' => 0,
        'category_id' => function () {
            return Categorie::where('state', 1)->inRandomOrder()->first()->id;
        },
        'last_user' => function () {
            return User::inRandomOrder()->first()->name;
        },
        'state' => $faker->numberBetween(0, 1)
    ];
});
