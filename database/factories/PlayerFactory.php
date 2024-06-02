<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Define an array of basketball positions
        $positions = ['Point Guard', 'Shooting Guard', 'Small Forward', 'Power Forward', 'Center'];

        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'salary' => $this->faker->randomFloat(2, 20000, 100000),
            // Use the array of positions to randomly pick one
            'position' => $this->faker->randomElement($positions),
        ];
    }
}
