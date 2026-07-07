<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
{
    // Hapus data user lama terlebih dahulu agar tidak duplikat saat diseed ulang
    \App\Models\User::truncate();

    // Akun 1: Pustakawan
    \App\Models\User::create([
        'name' => 'Wahyu Pustakawan',
        'email' => 'pustakawan@kampus.ac.id',
        'role' => 'pustakawan',
        'password' => Hash::make('rahasia123'),
    ]);

    // Akun 2: Anggota Biasa
    \App\Models\User::create([
        'name' => 'Wahyu Anggota',
        'email' => 'anggota@kampus.ac.id',
        'role' => 'anggota',
        'password' => Hash::make('anggota123'),
    ]);
}
}