<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'gender' => 'L',
            'phone' => '08123456789',
            'address' => 'Jl. Test Address No. 1',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
    }
}
