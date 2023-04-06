<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * test login.
     */
    public function test_login(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/api/auth/login', [
            'name' => $user->name,
            'password' => 'password'
        ]);

        $response->assertStatus(200);
    }

    /**
     * test logout.
     */
    public function test_logout(): void
    {
        $user = User::first();
        $token = \JWTAuth::fromUser($user);
    
        $this->post('api/auth/logout?token=' . $token)
            ->assertStatus(200)
            ->assertJsonStructure(['message']);
    
        $this->assertGuest('api');
    }
}
