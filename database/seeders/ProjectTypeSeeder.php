<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            0 => [
                'id' => 1,
                'name' => 'Blog',
            ],
            1 => [
                'id' => 2,
                'name' => 'Ecommerce'
            ],
            2 => [
                'id' => 3,
                'name' => 'Social'
            ],
            3 => [
                'id' => 4,
                'name' => 'Business' 
            ]
        ];

        DB::table('project_type')->insert($data);
    }
}
