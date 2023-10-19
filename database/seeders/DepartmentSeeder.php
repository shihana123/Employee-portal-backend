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
        DB::table('departments')->truncate();

        $data = [[
            'department' => 'Development'
        ],
        [
            'department' => 'Designing'
        ],
        [
            'department' => 'Testing'
        ],
        [
            'department' => 'Marketing'
        ],
        [
            'department' => 'HR'
        ]];
        DB::table('departments')->insert($data);
    }
}
