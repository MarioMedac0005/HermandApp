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

        // Primero elegimos un brotherhood al azar
        $brotherhood = Brotherhood::all()->random();

        // Si el brotherhood tiene procesiones, elegimos una al azar; si no, null
        $procession = $brotherhood->processions->isNotEmpty()
            ? $brotherhood->processions->random()
            : null;

        return [
            'date' => $this->faker->date(),
            'status' => 'pending',
            'amount' => $this->faker->randomFloat(2, 0, 10000),
            'description' => $this->faker->text(),
            'band_id' => Band::all()->random()->id,
            'brotherhood_id' => $brotherhood->id,
            'procession_id' => $procession?->id, // null-safe operator
        ];
    }
}
