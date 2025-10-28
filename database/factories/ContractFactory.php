<?php

namespace Database\Factories;

use App\Models\Band;
use App\Models\Procession;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $status = ['expired', 'pending', 'active'];

        return [
            'date' => fake()->date(),
            'status' => fake()->randomElement($status),
            'amount' => fake()->randomFloat(2, 0, 10000),
            'description' => fake()->text(),
            'band_id' => Band::all()->random()->id,
            'procession_id' => Procession::all()->random()->id,
            
        ];
    }
}
