<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Band>
 */
class BandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'name' => 'Banda' . fake()->unique()->company(),
            'city' => fake()->city(),
            'rehearsal_space' => fake()->streetAddress(),
            'email' => fake()->unique()->safeEmail()
        ];
    }
}
