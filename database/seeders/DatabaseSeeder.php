<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat akun Admin
        User::create([
            'name' => 'Admin SenjaKopi',
            'email' => 'admin@senjakopi.com',
            'password' => bcrypt('password123'), // Password untuk login
            'role' => 'admin',
        ]);

        // 2. Membuat akun Pelanggan biasa
        User::create([
            'name' => 'Afif',
            'email' => 'afif@senjakopi.com',
            'password' => bcrypt('12345678'),
            'role' => 'user',
        ]);

        // 3. Memanggil seeder produk kopi kita sebelumnya
        $this->call([
            ProductSeeder::class,
        ]);
    }
}