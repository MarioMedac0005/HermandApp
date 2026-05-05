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

    $statuses = [
        'pending',
        'rejected',
        'accepted',
        'signed_by_band',
        'signed_by_brotherhood',
        'completed',
        'paid',
        'payment_failed',
        'expired',
    ];

    $status = $this->faker->randomElement($statuses);

    $performanceDate = $this->faker->dateTimeBetween('-6 months', '+6 months');

    $signStart = min($performanceDate, now());
    $signEnd = max($performanceDate, now());

    return [
        'performance_type' => $this->faker->randomElement([
            'procession',
            'concert',
            'transfer',
            'festival',
            'other',
        ]),

        'performance_date' => $performanceDate,

        'approximate_route' => $this->faker->optional()->paragraph(),

        'duration' => $this->faker->numberBetween(60, 600),

        'minimum_musicians' => $this->faker->numberBetween(20, 120),

        'amount' => $this->faker->randomFloat(2, 500, 15000),

        'additional_information' => $this->faker->optional()->paragraph(),

        'status' => $status,

        // Firmas
        'signed_by_band_at' => in_array($status, ['signed_by_band', 'completed', 'paid'])
            ? $this->faker->dateTimeBetween($signStart, $signEnd)
            : null,

        'signed_by_brotherhood_at' => in_array($status, ['signed_by_brotherhood', 'completed', 'paid'])
            ? $this->faker->dateTimeBetween($signStart, $signEnd)
            : null,

        'paid_at' => $status === 'paid'
            ? $this->faker->dateTimeBetween($signStart, $signEnd)
            : null,

        // Stripe (fake)
        'stripe_session_id' => in_array($status, ['paid', 'payment_failed'])
            ? 'cs_test_' . $this->faker->uuid()
            : null,

        'stripe_payment_intent_id' => in_array($status, ['paid', 'payment_failed'])
            ? 'pi_' . $this->faker->uuid()
            : null,

        // PDFs opcionales
        'pdf_path' => 'contracts/sample.pdf',
        'band_signed_pdf_path' => in_array($status, ['signed_by_band', 'completed', 'paid'])
            ? 'contracts/band_signed.pdf'
            : null,
        'brotherhood_signed_pdf_path' => in_array($status, ['signed_by_brotherhood', 'completed', 'paid'])
            ? 'contracts/brotherhood_signed.pdf'
            : null,

        'band_signature_hash' => in_array($status, ['signed_by_band', 'completed', 'paid'])
            ? $this->faker->sha256()
            : null,
        'brotherhood_signature_hash' => in_array($status, ['signed_by_brotherhood', 'completed', 'paid'])
            ? $this->faker->sha256()
            : null,

        // Relaciones
        'band_id' => $band->id,
        'brotherhood_id' => $brotherhood->id,
        'procession_id' => $procession->id,
    ];
}
}
