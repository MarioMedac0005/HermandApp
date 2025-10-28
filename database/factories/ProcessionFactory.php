<?php

namespace Database\Factories;

use App\Models\Brotherhood;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Procession>
 */
class ProcessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
           $type = ['christ', 'virgin'];
        return [
            'name' => fake()->name(),
            'type' => fake()->randomElement($type),
            'itinerary' => fake()->text(),
            'checkout_time' => fake()->dateTime(),
            'checkin_time' => fake()->dateTime(),
            'brotherhood_id' => Brotherhood::all()->random()->id
        ];
    }
}
