<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ModelClient;
use Illuminate\Support\Facades\Hash;

class ModelClientControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_it_registers_a_new_user_and_returns_a_token()
    {
        $response = $this->postJson('/api/register', [
            'nom' => 'Doe',
            'prenom' => 'Jane',
            'email' => 'jane@example.com',
            'tel' => '0601020304',
            'password' => 'securePass123',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['token']);

        $this->assertDatabaseHas('clients', [
            'email' => 'jane@example.com',
        ]);
    }

    public function test_it_fails_to_register_with_existing_email()
    {
        ModelClient::factory()->create([
            'email' => 'jane@example.com',
        ]);

        $response = $this->postJson('/api/register', [
            'nom' => 'Duplicate',
            'prenom' => 'Jane',
            'email' => 'jane@example.com',
            'tel' => '0601020304',
            'password' => 'anotherPass123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_it_logs_in_a_client_and_returns_a_token()
    {
        $client = ModelClient::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    public function test_it_fails_to_login_with_invalid_credentials()
    {
        $client = ModelClient::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJsonFragment(['error' => 'Invalid credentials']);
    }

    public function test_it_lists_clients()
    {
        ModelClient::factory()->count(3)->create();

        $response = $this->getJson('/api/clients');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_it_stores_a_new_client()
    {
        $payload = [
            'nom' => 'Dupont',
            'prenom' => 'Alice',
            'email' => 'alice.dupont@example.com',
            'tel' => '0612345678',
            'password' => 'monMotDePasse123',
        ];

        $response = $this->postJson('/api/clients', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'email' => 'alice.dupont@example.com',
                'nom' => 'Dupont',
                'prenom' => 'Alice',
            ]);

        $this->assertDatabaseHas('clients', [
            'email' => 'alice.dupont@example.com',
            'nom' => 'Dupont',
            'prenom' => 'Alice',
        ]);
    }


    public function test_it_updates_a_client()
    {
        $client = ModelClient::factory()->create();

        $response = $this->putJson("/api/clients/{$client->id_client}", [
            'nom' => 'Nouveau',
            'prenom' => 'Nom',
            'email' => 'new@example.com',
            'tel' => '0612345678'
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['email' => 'new@example.com']);
    }

    public function test_it_deletes_a_client()
    {
        $client = ModelClient::factory()->create();

        $response = $this->deleteJson("/api/clients/{$client->id_client}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('clients', [
            'id_client' => $client->id_client
        ]);
    }
}
