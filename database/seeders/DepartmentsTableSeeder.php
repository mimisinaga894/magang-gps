<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsTableSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            ['name' => 'HRD'],
            ['name' => 'Finance'],
            ['name' => 'IT'],
            ['name' => 'Marketing'],
            ['name' => 'Sales'],
            ['name' => 'Production'],
            ['name' => 'Logistics'],
        ];

        DB::table('departments')->insert($departments);
    }
}

