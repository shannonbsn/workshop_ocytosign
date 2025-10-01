<?php

namespace Database\Factories;

use App\Models\ModelClient;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModelClientFactory extends Factory
{
    protected $model = ModelClient::class;

    public function definition(): array
    {
        return [
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName(),
            'email' => $this->faker->unique()->safeEmail(),
            'tel' => $this->faker->phoneNumber(),
        ];
    }
}
