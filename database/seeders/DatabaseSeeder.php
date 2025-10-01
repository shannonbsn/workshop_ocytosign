<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ModelClient;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        ModelClient::factory()->create([
            'nom' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
