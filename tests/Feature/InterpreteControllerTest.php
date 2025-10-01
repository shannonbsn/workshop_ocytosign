<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Medecin;
use App\Models\Interprete;

class InterpreteControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_index_returns_all_interpretres()
    {
        Interprete::factory()->count(3)->create();

        $response = $this->get('/interpretres');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_store_creates_an_interprete()
    {
        $medecin = Medecin::factory()->create();

        $data = [
            'id_medecin' => $medecin->id_medecin,
            'nom' => 'Durand',
            'prenom' => 'Claire',
        ];

        $response = $this->post('/interpretres', $data);

        $response->assertStatus(201)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('interpretres', $data);
    }

    public function test_show_returns_an_interprete()
    {
        $interprete = Interprete::factory()->create();

        $response = $this->get("/interpretres/{$interprete->id_interprete}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'nom' => $interprete->nom,
                'prenom' => $interprete->prenom,
            ]);
    }

    public function test_update_modifies_an_interprete()
    {
        $interprete = Interprete::factory()->create();
        $newMedecin = Medecin::factory()->create();

        $updatedData = [
            'id_medecin' => $newMedecin->id_medecin,
            'nom' => 'Martin',
            'prenom' => 'Julie',
        ];

        $response = $this->put("/interpretres/{$interprete->id_interprete}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);

        $this->assertDatabaseHas('interpretres', $updatedData);
    }

    public function test_destroy_deletes_an_interprete()
    {
        $interprete = Interprete::factory()->create();

        $response = $this->delete("/interpretres/{$interprete->id_interprete}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Supprimé avec succès']);

        $this->assertDatabaseMissing('interpretres', [
            'id_interprete' => $interprete->id_interprete,
        ]);
    }
}
