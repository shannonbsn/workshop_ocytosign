<?php

namespace Database\Factories;

use App\Models\Medecin;
use App\Models\Interprete;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Interprete>
 */
class InterpreteFactory extends Factory
{
    protected $model = Interprete::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_medecin' => Medecin::factory(),
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName(),
        ];
    }
}
