<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            0 => [
                'id' => 1,
                'name' => 'Nhận dự án',
            ],
            1 => [
                'id' => 2,
                'name' => 'Chuyển trưởng phòng Kỹ thuật'
            ],
            2 => [
                'id' => 3,
                'name' => 'Frontend'
            ],
            3 => [
                'id' => 4,
                'name' => 'Backend' 
            ],
            4 => [
                'id' => 5,
                'name' => 'Tester' 
            ]
        ];

        DB::table('project_status')->insert($data);
    }
}
