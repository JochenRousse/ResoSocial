<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::collection('users')->insert(['username' => 'Test', 'email' => 'test@yopmail.com', 'nom' => 'Dupont', 'prenom' => 'Jean', 'password' => bcrypt('test1234')]);
        DB::collection('users')->insert(['username' => 'Jojt', 'email' => 'jojt@yopmail.com', 'nom' => 'Rousse', 'prenom' => 'Jochen', 'password' => bcrypt('10031997')]);

    }
}