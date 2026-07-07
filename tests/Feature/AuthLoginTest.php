<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    public function testAllowsLoginWithSeededUserCredentials(): void
    {
        $this->seed(UserSeeder::class);

        $response = $this->post('/login', [
            'email' => 'anggota@kampus.ac.id',
            'password' => 'anggota123',
        ]);

        $response->assertRedirect('/produk');
        $this->assertAuthenticatedAs(User::where('email', 'anggota@kampus.ac.id')->first());
    }
}
