<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('client')->insert([
            [
                'firstName' => 'John',
                'lastName' => 'Doe',
                'gender' => 'Muški',
                'email' => 'john.doe@example.com',
                'phone' => '123456789',
                'dateOfBirth' => '1990-01-01',
                'status' => 'Aktivan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'firstName' => 'Jane',
                'lastName' => 'Doe',
                'gender' => 'Ženski',
                'email' => 'jane.doe@example.com',
                'phone' => '987654321',
                'dateOfBirth' => '1992-05-15',
                'status' => 'Neaktivan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'firstName' => 'Bob',
                'lastName' => 'Smith',
                'gender' => 'Muški',
                'email' => 'bob.smith@example.com',
                'phone' => '555123456',
                'dateOfBirth' => '1985-07-20',
                'status' => 'Aktivan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'firstName' => 'Alice',
                'lastName' => 'Johnson',
                'gender' => 'Ženski',
                'email' => 'alice.johnson@example.com',
                'phone' => '777987654',
                'dateOfBirth' => '1988-12-10',
                'status' => 'Neaktivan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'firstName' => 'Charlie',
                'lastName' => 'Brown',
                'gender' => 'Muški',
                'email' => 'charlie.brown@example.com',
                'phone' => '444567890',
                'dateOfBirth' => '1995-03-25',
                'status' => 'Aktivan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'firstName' => 'Eva',
                'lastName' => 'Miller',
                'gender' => 'Ženski',
                'email' => 'eva.miller@example.com',
                'phone' => '111222333',
                'dateOfBirth' => '1998-08-05',
                'status' => 'Neaktivan',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        $client = DB::table('client')->get();

        foreach ($client as $cl) {
            DB::table('feerecords')->insert([
                'clientID' => $cl->id,
                'dateOfPayment' => now(),  
                'dateExpiry' => now()->addMonths(1),  
                'membershipFee' => 50.00,  
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
