<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'example',
            'email' => 'example@gmail.com',
            'password' => Hash::make('example123')
        ]);

        DB::table('users')->insert([
            'name' => 'juan',
            'email' => 'juan@gmail.com',
            'password' => Hash::make('juan123')
        ]);
    }
}
