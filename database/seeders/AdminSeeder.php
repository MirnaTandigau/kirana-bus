<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat Akun Admin
        User::create([
            'name' => 'Admin Kirana',
            'email' => 'admin@kirana.com',
            'password' => Hash::make('passwordadmin123'),
            'is_admin' => true, // Memberikan hak akses admin
        ]);

        // Membuat Akun User Biasa untuk Testing
        User::create([
            'name' => 'Pengguna Kirana',
            'email' => 'user@gmail.com',
            'password' => Hash::make('passworduser123'),
            'is_admin' => false,
        ]);
    }
}