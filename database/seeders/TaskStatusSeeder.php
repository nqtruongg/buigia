<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            0 => [
                'id' => 1,
                'name' => 'Nhận công việc',
            ],
            1 => [
                'id' => 2,
                'name' => 'Đang dev'
            ],
            2 => [
                'id' => 3,
                'name' => 'Chờ test'
            ],
            3 => [
                'id' => 4,
                'name' => 'Đang test' 
            ],
            4 => [
                'id' => 5,
                'name' => 'Bug' 
            ],
            5 => [
                'id' => 6,
                'name' => 'Hoàn thành' 
            ]
        ];

        DB::table('task_status')->insert($data);
    }
}
