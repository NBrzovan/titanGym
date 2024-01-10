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
        $pass = Hash::make('12345678');
        DB::table('user')->insert([
            ['name' => 'admin', 'email' => 'admin@gmail.com', 'password' => $pass, 'role_id' => 2],   
        ]);
    }
}
