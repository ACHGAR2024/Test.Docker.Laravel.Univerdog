<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class DatabaseConnectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_connection()
    {
        // Attempts to connect to the database and execute a simple query
        try {
            DB::connection()->getPdo();
            $this->assertTrue(true, "Database connection successful.");
        } catch (\Exception $e) {
            $this->fail("Database connection failed: " . $e->getMessage());
        }
    }

    public function test_database_connection_with_invalid_credentials()
    {
        // Attempts to connect to the database with invalid credentials
        config(['database.connections.mysql.username' => 'invalid_user']);
        config(['database.connections.mysql.password' => 'invalid_password']);

        try {
            DB::connection()->getPdo();
            $this->fail("Database connection should have failed with invalid credentials.");
        } catch (\Exception $e) {
            $this->assertTrue(true, "Database connection failed as expected: " . $e->getMessage());
        }
    }

    public function test_database_query_execution()
    {
        // Attempts to execute a simple query on the database
        DB::table('users')->insert(['name' => 'Test User', 'email' => 'test@example.com']);
        $user = DB::table('users')->where('email', 'test@example.com')->first();

        $this->assertNotNull($user, "User should be found in the database.");
        $this->assertEquals('Test User', $user->name, "User's name should match.");
    }
}