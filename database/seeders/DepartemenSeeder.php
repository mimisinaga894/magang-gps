<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departemens = [
            [
                'kode' => 'HRD',
                'nama' => 'Human Resource Development',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'FIN',
                'nama' => 'Finance',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'IT',
                'nama' => 'Information Technology',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'MKT',
                'nama' => 'Marketing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'OPR',
                'nama' => 'Operations',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('departemen')->insert($departemens);
    }
}
