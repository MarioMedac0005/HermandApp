<?php

namespace Database\Factories;

use App\Models\Procession;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProcessionFactory extends Factory
{
    protected $model = Procession::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['christ', 'virgin']),
            'status' => 'published',
            'distance' => $this->faker->randomFloat(2, 1.5, 4.0),
            'checkout_time' => now()->setTime(16, 0),
            'checkin_time' => now()->setTime(23, 0),
            'preview_url' => 'https://via.placeholder.com/640x480.png',
            'brotherhood_id' => rand(1, 4),
        ];
    }
}
