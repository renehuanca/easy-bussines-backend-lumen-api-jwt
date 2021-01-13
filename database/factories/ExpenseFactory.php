<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use App\Expense;

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

$factory->define(Expense::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'amount' => $faker->numberBetween(100, 200),
        'type' => $faker->word,
        'last_user' => function () {
            return User::inRandomOrder()->first()->id;
        },
        'is_deleted' => $faker->numberBetween(0, 1)
    ];
});
