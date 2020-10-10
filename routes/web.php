<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

$router->get('/', 'WelcomeController@index');


// api router group with prefix api
$router->group(['prefix' => 'api/v1'], function() use ($router) {
    // Matches /api/users
    $router->post('users', 'AuthController@register');
    $router->post('login', 'AuthController@login');
    $router->post('me', 'AuthController@me');
    $router->post('logout', 'AuthController@logout');
    $router->post('refresh', 'AuthController@refresh');

    $router->get('users', 'UserController@showAllUsers');
    $router->put('users/{id}', 'UserController@update');

    // Matches /api/customers
    $router->get('customers', 'CustomerController@index');
    $router->get('customers/{id}', 'CustomerController@show');
    $router->post('customers', 'CustomerController@store');
    $router->put('customers/{id}', 'CustomerController@update');
    $router->delete('customers/{id}', 'CustomerController@delete');

    //categories
    $router->get('categories', 'CategoryController@index');
    $router->get('categories/{id}', 'CategoryController@show');
    $router->post('categories', 'CategoryController@store');
    $router->put('categories/{id}', 'CategoryController@update');
    $router->delete('categories/{id}', 'CategoryController@delete');

});

// Generate key to .env
$router->get('/key', function() {
    return \Illuminate\Support\Str::random(32);
});


