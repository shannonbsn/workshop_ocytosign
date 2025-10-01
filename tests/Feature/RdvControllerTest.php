<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\ModelClient;
use App\Models\ModelRdv;
use App\Models\Medecin;
use App\Models\Interprete;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RdvControllerTest extends TestCase
{
    use RefreshDatabase;
    

    public function test_index_returns_all_rdvs(): void
    {
        $rdv = ModelRdv::factory()->create();

        $response = $this->get('/rdvs');

        $response->assertStatus(200)
                 ->assertJsonFragment(['id_rdv' => $rdv->id_rdv]);
    }

    public function test_store_creates_an_rdv(): void
    {

        $client = ModelClient::factory()->create();
        $medecin = Medecin::factory()->create();
        $interprete = Interprete::factory()->create();

        $data = [
            'id_client' => $client->id_client,
            'id_medecin' => $medecin->id_medecin,
            'id_interprete' => $interprete->id_interprete,
            'date_debut' => '2025-10-02 14:03:15',
            'date_fin' => '2025-10-02 15:03:15',
            'presentiel' => true,
        ];

        $response = $this->postJson('/rdvs', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('rdvs', $data);
    }

    public function test_show_returns_an_rdv(): void
    {
        $rdv = ModelRdv::factory()->create();

        $response = $this->get('/rdvs/'.$rdv->id_rdv);

        $response->assertStatus(200)
                 ->assertJson(['id_rdv' => $rdv->id_rdv]);
    }

    public function test_update_modifies_an_rdv(): void
    {
        $rdv = ModelRdv::factory()->create();

        $data = ['date_fin' => now()->addDays(3)->toDateTimeString(), 'presentiel' => false];

        $response = $this->put('/rdvs/'.$rdv->id_rdv, $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('rdvs', ['id_rdv' => $rdv->id_rdv, 'date_fin' => $data['date_fin']]);
    }

    public function test_destroy_deletes_an_rdv(): void
    {
        $rdv = ModelRdv::factory()->create();

        $response = $this->delete('/rdvs/'.$rdv->id_rdv);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('rdvs', ['id_rdv' => $rdv->id_rdv]);
    }
}
