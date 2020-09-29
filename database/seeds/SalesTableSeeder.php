<?php

use Illuminate\Database\Seeder;
use App\Sale;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Sale::class, 5)->create();
    }
}
