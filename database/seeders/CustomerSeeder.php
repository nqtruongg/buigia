<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            0 => [
                'id' => 1,
                'name' => 'Customer1',
                'email' => 'customer1@gmail.com',
                'password' => Hash::make('123456'),
            ],
            1 => [
                'id' => 2,
                'name' => 'Customer2',
                'email' => 'customer2@gmail.com',
                'password' => Hash::make('123456'),
            ],
            2 => [
                'id' => 3,
                'name' => 'Customer3',
                'email' => 'customer3@gmail.com',
                'password' => Hash::make('123456'),
            ],
            3 => [
                'id' => 4,
                'name' => 'Customer4',
                'email' => 'customer4@gmail.com',
                'password' => Hash::make('123456'),
            ],
            4 => [
                'id' => 5,
                'name' => 'Customer5',
                'email' => 'customer5@gmail.com',
                'password' => Hash::make('123456'),
            ]
        ];

        DB::table('customers')->insert($data);
    }
}
