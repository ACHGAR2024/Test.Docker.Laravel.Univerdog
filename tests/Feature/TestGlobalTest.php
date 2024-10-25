<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TestGlobalTest extends TestCase
{
    use RefreshDatabase;

    // 1. Unit Tests
    public function test_user_model_methods()
    {
       
        $user = new User(['name' => 'Test User']);
        $this->assertEquals('Test User', $user->name, "The user's name should be 'Test User'");
    }

    // 2. Functional Tests
    public function test_user_controller_routes()
    {
        
        $user = User::factory()->create();
        $this->actingAs($user); // Authenticate the user
        $response = $this->get('/api/users');
        $response->assertStatus(200, "The /api/users route should return a 200 status");
    }


    // 3. Migration Tests
    public function test_database_migrations()
    {
       
        $tables = DB::select('SHOW TABLES');
        $this->assertNotEmpty($tables, "Database tables should be present after migrations");
    }

   

    // 4. API Tests
    public function test_user_api_endpoints()
    {
       
        $user = User::factory()->create();
        $this->actingAs($user, 'api'); // Authenticate the user for the API
        $response = $this->getJson('/api/users');
        $response->assertStatus(200, "The /api/users API should return a 200 status");
    }

    // 5. Middleware Tests
    public function test_auth_middleware()
    {
        // Create a protected route with auth middleware for testing
        $this->app['router']->get('/api/logout', function () {
            return 'Access authorized';
        })->middleware('auth');

        // Try to access the route without being authenticated
        $response = $this->get('/api/logout');
        $response->assertStatus(302, "Access to a protected route without authentication should redirect");

        // Create and authenticate a user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Try to access the route while authenticated
        $response = $this->get('/api/logout');
        $response->assertStatus(200, "Access to a protected route with authentication should be authorized");
        $response->assertSee('Access authorized', "The content of the protected route should be visible after authentication");
    }
}