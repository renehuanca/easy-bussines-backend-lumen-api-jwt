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

// api router group with prefix /api/v1
$router->group(['prefix' => 'api/v1'], function() use ($router) {
    // Matches with api/v1

    // auth
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
    $router->post('me', 'AuthController@me');
    $router->post('logout', 'AuthController@logout');
    $router->post('refresh', 'AuthController@refresh');

    // Dashboard
        // Cards in dashboard
        $router->get('monthly-earning', 'DashboardController@monthlyEarning');
        $router->get('annual-earning', 'DashboardController@annualEarning');
        $router->get('earnings-per-month-diagram', 'DashboardController@earningsPerMonthDiagram');
        // $router->get('earnings-per-day-this-week', 'DashboardController@earningsPerDayThisWeek');


    // users
    $router->post('update-password', 'UpdatePasswordController@update');
    $router->get('users', 'UserController@index');
    $router->get('users/{id}', 'UserController@edit');
    $router->put('users/{id}', 'UserController@update');
    $router->delete('users/{id}', 'UserController@active');

    // customers
    $router->get('customers', 'CustomerController@index');
    $router->get('customers/{id}', 'CustomerController@show');
    $router->post('customers', 'CustomerController@store');
    $router->put('customers/{id}', 'CustomerController@update');
    $router->delete('customers/{id}', 'CustomerController@delete');

    //products
    $router->get('products', 'ProductController@index');
    $router->get('products/{id}', 'ProductController@show');
    $router->post('products', 'ProductController@store');
    $router->put('products/{id}', 'ProductController@update');
    $router->delete('products/{id}', 'ProductController@delete');

    //categories
    $router->get('categories', 'CategoryController@index');
    $router->get('categories/{id}', 'CategoryController@show');
    $router->post('categories', 'CategoryController@store');
    $router->put('categories/{id}', 'CategoryController@update');
    $router->delete('categories/{id}', 'CategoryController@delete');

    //sales
    $router->get('sales', 'SaleController@index');
    $router->get('sales/{id}', 'SaleController@show');
    $router->post('sales', 'SaleController@store');
    $router->delete('sales/{id}', 'SaleController@delete');

    // general settings
    $router->get('settings/{id}', 'SettingController@show');
    $router->put('settings/{id}', 'SettingController@update');
});

// Generate key to .env
$router->get('/key', function() {
    return \Illuminate\Support\Str::random(32);
});


