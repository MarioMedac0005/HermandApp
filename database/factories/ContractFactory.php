<?php

namespace Database\Factories;

use App\Models\Band;
use App\Models\Brotherhood;
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
    public function definition()
    {
        $brotherhood = Brotherhood::inRandomOrder()->first() ?? Brotherhood::factory()->create();
        $band = Band::inRandomOrder()->first() ?? Band::factory()->create();

        $procession = Procession::where('brotherhood_id', $brotherhood->id)
            ->inRandomOrder()
            ->first();

        if (!$procession) {
            $procession = Procession::factory()->create([
                'brotherhood_id' => $brotherhood->id,
            ]);
        }

        $performanceTypes = [
            'procession',
            'concert',
            'transfer',
            'festival',
            'other',
        ];

        return [
            'performance_type' => $this->faker->randomElement($performanceTypes),

            'performance_date' => $this->faker->dateTimeBetween('now', '+1 year'),

            'approximate_route' => $this->faker->optional()->paragraph(),

            'duration' => $this->faker->numberBetween(60, 600),

            'minimum_musicians' => $this->faker->numberBetween(20, 120),

            'amount' => $this->faker->randomFloat(2, 500, 15000),

            'additional_information' => $this->faker->optional()->paragraph(),

            'status' => 'pending',

            'band_id' => $band->id,
            'brotherhood_id' => $brotherhood->id,
            'procession_id' => $procession->id,

            'signed_by_band_at' => null,
            'signed_by_brotherhood_at' => null,
            'paid_at' => null,
        ];
    }
}
