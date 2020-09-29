<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            CustomerTableSeeder::class,
            CategoriesTableSeeder::class,
            ProductsTableSeeder::class,
            SalesTableSeeder::class,
            ExpensesTableSeeder::class
        ]);
    }
}
