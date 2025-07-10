<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Karyawan;
use App\Models\LokasiKantor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'gender' => 'L',
            'phone' => '08123456789',
            'address' => 'Jl. Admin No. 1',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'email_verified_at' => now()
        ]);

        // Seed departemen
        $this->call(DepartemenSeeder::class);

        // Create default office location
        LokasiKantor::create([
            'kota' => 'Jakarta',
            'alamat' => 'Jl. Kantor Pusat No. 1',
            'latitude' => -6.2088,
            'longitude' => 106.8456,
            'radius' => 100,
            'is_used' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Create sample karyawan
        $user = User::create([
            'name' => 'Joni Iskandar',
            'username' => 'joni',
            'email' => 'joni@mail.com',
            'gender' => 'L',
            'phone' => '08567890123',
            'address' => 'Jl. Karyawan No. 1',
            'password' => bcrypt('password'),
            'role' => 'karyawan',
            'email_verified_at' => now()
        ]);

        Karyawan::create([
            'nik' => 'K00001',
            'user_id' => $user->id,
            'departemen_id' => 3,
            'nama_lengkap' => 'Joni Iskandar',
            'jabatan' => 'Software Engineer',
        ]);
    }
}
