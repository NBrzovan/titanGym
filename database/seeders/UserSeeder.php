<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $passVlada = Hash::make('adminVlada1!');
        $passAna = Hash::make('adminAna1!');

        DB::table('user')->insert([
            ['firstName' => 'Vlada', 'lastName' => 'Jovčevski', 'email' => 'adminVlada@gmail.com', 'password' => $passVlada, 'role_id' => 2],   
            ['firstName' => 'Ana', 'lastName' => 'Bena', 'email' => 'adminAna@gmail.com', 'password' => $passAna, 'role_id' => 2]
        ]);
    }
}
