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
        ['kode' => 'HRD', 'nama' => 'Human Resource Development'],
        ['kode' => 'FIN', 'nama' => 'Finance'],
        ['kode' => 'IT',  'nama' => 'Information Technology'],
        ['kode' => 'MKT', 'nama' => 'Marketing'],
        ['kode' => 'OPR', 'nama' => 'Operations'],
    ];

    foreach ($departemens as $departemen) {
        \DB::table('departemen')->updateOrInsert(
            ['kode' => $departemen['kode']], 
            [
                'nama' => $departemen['nama'],
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}