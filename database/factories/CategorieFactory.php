<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Categorie;
// use App\User;
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

$factory->define(Categorie::class, function (Faker $faker) {
    // $user = User::find(rand(0, 3));
    return [
        'name' => $faker->name,
        'last_user' => $faker->name,
        'state' => $faker->numberBetween(0, 1)
    ];
});
