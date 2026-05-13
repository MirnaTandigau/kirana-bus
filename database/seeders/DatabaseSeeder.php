<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Tambahkan ini

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun Admin
        User::create([
            'name' => 'Admin Kirana',
            'email' => 'admin@kirana.com',
            'password' => Hash::make('passwordadmin123'), // Password otomatis dienkripsi
            'is_admin' => 1, // Sesuai dengan kolom is_admin di database Anda
        ]);

        // Membuat akun User/Pelanggan biasa
        User::create([
            'name' => 'Pelanggan Test',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password123'),
            'is_admin' => 0,
        ]);
    }
}