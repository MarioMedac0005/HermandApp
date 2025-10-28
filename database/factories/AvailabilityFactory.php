<?php

namespace Database\Factories;

use App\Models\Band;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Availability>
 */
class AvailabilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = ['free', 'occupied'];

        return [
       
            'date' => fake()->date(),
            'status' => fake()->randomElement($status),
            'description' => fake()->text(),
            'band_id' => Band::all()->random()->id
         
        ];
    }
}
