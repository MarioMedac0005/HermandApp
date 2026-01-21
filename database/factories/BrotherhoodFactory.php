<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brotherhood>
 */
class BrotherhoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'name' => fake()->name(),
            'city' => fake()->randomElement(['Almeria', 'Cadiz', 'Cordoba', 'Granada', 'Huelva', 'Jaen', 'Malaga', 'Sevilla']),
            'office' => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'email' => fake()->email(),
        ];
    }
}
