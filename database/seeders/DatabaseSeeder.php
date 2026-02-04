<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Barang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat User Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Buat User Petugas
        User::create([
            'name' => 'Petugas Gudang',
            'email' => 'petugas@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
        ]);

        // 3. Buat User Peminjam
        User::create([
            'name' => 'Siswa Peminjam',
            'email' => 'siswa@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'peminjam',
        ]);

        // 4. Buat Data Barang Awal
        Barang::create(['nama_barang' => 'Kamera Canon EOS', 'stok' => 5]);
        Barang::create(['nama_barang' => 'Tripod Takara', 'stok' => 10]);
        Barang::create(['nama_barang' => 'Laptop Lab', 'stok' => 20]);
    }
}