<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => \ucwords($this->faker->unique()->city . ' ' . $this->faker->word),
            'stadium' => $this->faker->name(),
            'numMembers' => $this->faker->numberBetween(300000, 9000000),
            'budget' => $this->faker->randomFloat(2, 50000,1000000)
        ];
    }
}
