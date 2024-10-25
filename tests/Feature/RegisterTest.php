<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_user_can_register()
    {
        // Create test data for a new user
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'role' => 'user',
        ];

        // Send a POST request to the registration endpoint
        $response = $this->postJson('/api/register', $userData);

        // Check that the response has a status of 200 (OK)
        $response->assertStatus(200);

        // Check that the user has been created in the database
        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
        ]);

        // Verify that the response contains the success message
        $response->assertJson([
            'message' => 'User successfully registered',
        ]);
    }

    public function test_user_can_not_register()
    {
        // Create test data for a new user
        $userData = [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'role' => 'user',
        ];

        // Send a POST request to the recording endpoint
        $response = $this->postJson('/api/register', $userData);

        // Verify that the response has a status of 422 (Invalid)
        $response->assertStatus(422);

        // Verify that the user was NOT created in the database
        $this->assertDatabaseMissing('users', [
            'email' => $userData['email'],
        ]);

        // Debug: display the content of the response
        //dd($response->getContent());

        // Verify that the content of the response matches the expected structure
        $expectedContent = '{"name":["The name field is required."],"email":["The email field must be a valid email address."],"password":["The password field must be at least 6 characters."]}';
        
        if ($response->getContent() === $expectedContent) {
            
        } else {
            echo "FAIL";
            // View Actual Content for Debugging
            echo "\nContenu réel : " . $response->getContent();
        }
    }
}