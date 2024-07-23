<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            0 => [
                'id' => 1,
                'first_name' => 'Cao Xuân',
                'last_name' => 'Hải',
                'email' => 'hai@gmail.com',
                'password' => Hash::make('123456'),
            ],
            1 => [
                'id' => 2,
                'first_name' => 'Trần Văn',
                'last_name' => 'Luân',
                'email' => 'luan@gmail.com',
                'password' => Hash::make('123456'),
            ],
            2 => [
                'id' => 3,
                'first_name' => 'Vũ Hồng',
                'last_name' => 'Thanh',
                'email' => 'thanh@gmail.com',
                'password' => Hash::make('123456'),
            ],
            3 => [
                'id' => 4,
                'first_name' => 'Nguyễn Văn',
                'last_name' => 'Hoàng',
                'email' => 'hoang@gmail.com',
                'password' => Hash::make('123456'), 
            ],
            4 => [
                'id' => 5,
                'first_name' => 'Nguyễn Văn',
                'last_name' => 'Bê',
                'email' => 'be@gmail.com',
                'password' => Hash::make('123456'), 
            ]
        ];

        DB::table('users')->insert($data);
    }
}
