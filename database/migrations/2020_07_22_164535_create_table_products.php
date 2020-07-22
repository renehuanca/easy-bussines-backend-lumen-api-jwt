<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('id_category')->references('id')->on('categories');
            $table->string('phone');
            $table->string('company');
            $table->string('country');
            $table->string('city');
            $table->string('website');
            $table->string('social');
            $table->text('history');
            $table->string('last_user');
            $table->tinyInteger('state');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
}
