<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            0 => [
                'id' => 1,
                'name' => 'view',
                'type' => 0
            ],
            1 => [
                'id' => 2,
                'name' => 'add',
                'type' => 1
            ],
            2 => [
                'id' => 3,
                'name' => 'edit',
                'type' => 2
            ],
            3 => [
                'id' => 4,
                'name' => 'delete',
                'type' => 3
            ],
            4 => [
                'id' => 5,
                'name' => 'export',
                'type' => 4
            ],
        ];
        DB::table('permissions')->insert($data);
    }
}
