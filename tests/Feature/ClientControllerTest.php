<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\ModelClient;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModelClientTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_lists_clients()
    {
        ModelClient::factory()->count(3)->create();

        $response = $this->getJson('/api/clients');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /** @test */
    public function it_creates_a_client()
    {
        $response = $this->postJson('/api/clients', [
            'nom' => 'Doe',
            'prenom' => 'John',
            'email' => 'john.doe@example.com',
            'tel' => '0700000000'
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['email' => 'john.doe@example.com']);
    }

    /** @test */
    public function it_updates_a_client()
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

    /** @test */
    public function it_deletes_a_client()
    {
        $client = ModelClient::factory()->create();

        $response = $this->deleteJson("/api/clients/{$client->id_client}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('clients', [
            'id_client' => $client->id_client
        ]);
    }
}
