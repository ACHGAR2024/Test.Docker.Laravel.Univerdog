<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_user_can_login()
    {
        // Create a user for the test
        $user = User::factory()->create([
            'password' => bcrypt($password = 'password123'),
        ]);

        // Send a POST request to the login endpoint
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        // Check that the response has a 200 status (OK)
        $response->assertStatus(200);

        // Check that the response contains an access token
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
        ]);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        // Create a user for the test
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        // Send a POST request with invalid credentials
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        // Check that the response has a 401 status (Unauthorized)
        $response->assertStatus(401);

        // Check that the response contains an error message
        $response->assertJson([
            'error' => 'Unauthorized',
        ]);
    }
}
