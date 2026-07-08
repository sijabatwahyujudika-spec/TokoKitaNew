<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Nonaktifkan pengecekan foreign key agar bisa melakukan truncate tanpa error
        Schema::disableForeignKeyConstraints();

        // Hapus data user lama terlebih dahulu agar tidak duplikat saat diseed ulang
        User::truncate();

        // 2. Aktifkan kembali pengecekan foreign key setelah truncate selesai
        Schema::enableForeignKeyConstraints();

        // Akun 1: Pustakawan
        User::create([
            'name' => 'Wahyu Pustakawan',
            'email' => 'pustakawan@kampus.ac.id',
            'role' => 'pustakawan',
            'password' => Hash::make('rahasia123'),
        ]);

        // Akun 2: Anggota Biasa
        User::create([
            'name' => 'Wahyu Anggota',
            'email' => 'anggota@kampus.ac.id',
            'role' => 'anggota',
            'password' => Hash::make('anggota123'),
        ]);
    }
}