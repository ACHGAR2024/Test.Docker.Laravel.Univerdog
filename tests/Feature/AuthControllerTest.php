<?php

namespace Tests\Feature;

use Tests\PestTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

// Utiliser le trait RefreshDatabase ici
uses(RefreshDatabase::class);

beforeEach(function () {
    // S'assurer que la base de données est rafraîchie avant chaque test
    $this->refreshDatabase();
});

it('can register a user', function () {
    $response = $this->postJson('http://127.0.0.1:8080/api/register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'role' => 'user',
    ]);

    $response->assertStatus(201); // Vérifie que la réponse est un succès
    $response->assertJson([
        'message' => 'User successfully registered',
        'user' => [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ],
    ]);
});

it('can login a user', function () {
    // Créer l'utilisateur ici pour éviter les conflits
    User::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => bcrypt('password123'),
        'role' => 'user',
    ]);

    $response = $this->postJson('http://127.0.0.1:8080/api/login', [
        'email' => 'john@example.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(200); // Vérifie que la connexion a réussi
    $this->assertArrayHasKey('token', $response->json()); // Vérifie que le token est présent
});

it('fails to login with incorrect credentials', function () {
    $response = $this->postJson('http://127.0.0.1:8080/api/login', [
        'email' => 'nonexistent@example.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertStatus(401); // Vérifie que la connexion a échoué
    $response->assertJson([
        'error' => 'Unauthorized',
    ]);
});