<?php

use App\Models\User;
use Database\Seeders\UserSeeder;

it('allows login with seeded user credentials', function () {
    $this->seed(UserSeeder::class);

    $response = $this->post('/login', [
        'email' => 'anggota@kampus.ac.id',
        'password' => 'anggota123',
    ]);

    $response->assertRedirect('/produk');
    $this->assertAuthenticatedAs(User::where('email', 'anggota@kampus.ac.id')->first());
});
