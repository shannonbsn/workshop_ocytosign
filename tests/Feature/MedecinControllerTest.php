<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Medecin;

class MedecinControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    use RefreshDatabase, WithFaker;

    public function test_index_returns_all_medecins()
    {
        Medecin::factory()->count(3)->create();

        $response = $this->get('/medecins');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_store_creates_a_medecin()
    {
        $data = [
            'nom' => 'Durand',
            'prenom' => 'Claire',
        ];

        $response = $this->post('/medecins', $data);

        $response->assertStatus(201)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('medecins', $data);
    }

    public function test_show_returns_a_medecin()
    {
        $medecin = Medecin::factory()->create();

        $response = $this->get("/medecins/{$medecin->id_medecin}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'nom' => $medecin->nom,
                'prenom' => $medecin->prenom,
            ]);
    }

    public function test_update_modifies_a_medecin()
    {
        $medecin = Medecin::factory()->create();

        $updatedData = [
            'nom' => 'Martin',
            'prenom' => 'Julie',
        ];

        $response = $this->put("/medecins/{$medecin->id_medecin}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);

        $this->assertDatabaseHas('medecins', $updatedData);
    }

    public function test_destroy_deletes_a_medecin()
    {
        $medecin = Medecin::factory()->create();

        $response = $this->delete("/medecins/{$medecin->id_medecin}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Supprimé avec succès']);

        $this->assertDatabaseMissing('medecins', [
            'id_medecin' => $medecin->id_medecin,
        ]);
    }
}
