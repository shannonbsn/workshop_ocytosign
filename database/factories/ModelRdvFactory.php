<?php

namespace Database\Factories;

use App\Models\ModelRdv;
use App\Models\Medecin;
use App\Models\Interprete;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModelRdvFactory extends Factory
{
    protected $model = ModelRdv::class;

    public function definition(): array
    {
        $dateDebut = $this->faker->dateTimeBetween('+1 days', '+2 days');
        $dateFin = (clone $dateDebut)->modify('+1 hour');

        return [
            'id_medecin' => Medecin::factory(),
            'id_interprete' => Interprete::factory(),
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'presentiel' => $this->faker->boolean(),
        ];
    }
}
