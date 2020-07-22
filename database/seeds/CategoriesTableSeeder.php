<?php

use Illuminate\Database\Seeder;
use App\Categorie;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Categorie::class, 20)->make();
    }
}
