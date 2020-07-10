<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Builder; 

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Solution to error in mysql in heroku
     *
     * @return void
     */
    public function boot()
    {
        Builder::defaultStringLength(191); 
    }
}
