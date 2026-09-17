<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat Akun Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@testing.com',
            'password' => Hash::make('pass123'),
            'role' => 'admin',
        ]);

        // 2. Membuat Akun User Biasa
        User::create([
            'name' => 'User Mahasiswa',
            'email' => 'user@testing.com',
            'password' => Hash::make('pass123'),
            'role' => 'user',
        ]);
    }
}