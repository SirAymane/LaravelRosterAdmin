<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Using Laravel's factory to create teams and associate players with them
        \App\Models\Team::factory()
            ->count(rand(10, 15)) // Randomly choosing a count between 10 and 15 for teams
            ->hasPlayers(rand(5, 10)) // Each team will have between 5 and 15 players
            ->create();
    }
}
