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
    $procession = Procession::inRandomOrder()->first() ?? Procession::factory()->create();
    $band = Band::inRandomOrder()->first() ?? Band::factory()->create();
        $status = ['expired', 'pending', 'active'];

        return [
        'date' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
        'status' => 'pending',
        'amount' => $this->faker->randomFloat(2, 100, 10000),
        'description' => $this->faker->paragraph(),
        'band_id' => $band->id,
        'procession_id' => $procession->id,
        'brotherhood_id' => $procession->brotherhood_id,
        ];
    }
}
