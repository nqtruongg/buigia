<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
   /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            0 => [
                'id' => 1,
                'name' => 'Phòng kỹ thuật',
            ],
            1 => [
                'id' => 2,
                'name' => 'Phòng hành chính, nhân sự',
            ],
            2 => [
                'id' => 3,
                'name' => 'Phòng kinh doanh',
            ],
        ];

        DB::table('departments')->insert($data);
    }
}
