<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LokasiKantor;

class LokasiKantorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lokasi = [
            [
                'kota' => 'Jakarta',
                'alamat' => 'Jl. Kantor Pusat No. 1',
                'latitude' => -6.2088,
                'longitude' => 106.8456,
                'radius' => 100,
                'is_used' => true
            ],
            [
                'kota' => 'Surabaya',
                'alamat' => 'Jl. Kantor Cabang No. 1',
                'latitude' => -7.2575,
                'longitude' => 112.7521,
                'radius' => 100,
                'is_used' => false
            ]
        ];

        foreach ($lokasi as $loc) {
            LokasiKantor::create($loc);
        }
    }
}
