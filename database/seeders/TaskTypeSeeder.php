<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            0 => [
                'id' => 1,
                'name' => 'Tính năng',
            ],
            1 => [
                'id' => 2,
                'name' => 'Bug'
            ],
        ];

        DB::table('task_types')->insert($data);
    }
}
