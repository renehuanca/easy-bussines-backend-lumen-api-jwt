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
            'name' => 'rene',
            'first_name' => 'René Gonzalo',
            'last_name' => 'Huanca Mamani',
            'address' => 'z. Senkata 79 av Uvinas #1021',
            'city' => 'El Alto',
            'country' => 'Bolivia',
            'about_me' => 'Todos necesitamos embriagarnos de algo para seguir adelante.',
            'phone' => '78828568',
            'email' => 'rene@gmail.com',
            'password' => Hash::make('rene123'),
            'last_user' => 'juan',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        DB::table('users')->insert([
            'name' => 'juan',
            'first_name' => 'Juan',
            'last_name' => 'Quispe',
            'address' => 'Ventilla #1021',
            'city' => 'El Alto',
            'country' => 'Bolivia',
            'about_me' => 'Debe ser una descripcion nuestra',
            'phone' => '7747733',
            'email' => 'juan@gmail.com',
            'password' => Hash::make('juan123'),
            'last_user' => 'juan',
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);

        factory(User::class, 20)->create();
    }
}
