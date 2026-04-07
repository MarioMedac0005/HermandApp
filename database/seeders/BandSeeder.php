<?php

namespace Database\Seeders;

use App\Models\Band;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Stripe\StripeClient;

class BandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clave secreta de Stripe
        $stripeSecret = env('STRIPE_SECRET');
        if (!$stripeSecret) {
            throw new \Exception("Stripe secret key not found in .env");
        }

        $stripe = new StripeClient($stripeSecret);

        $bandsData = [
            [
                'name' => 'Banda de Música de la Veracruz',
                'description' => 'La Banda de Música de la Veracruz es una formación con una sólida trayectoria dentro del panorama musical cofrade, reconocida por la calidad de sus interpretaciones y su compromiso con la tradición. Su repertorio abarca marchas procesionales clásicas y contemporáneas, destacando por su elegancia sonora y su capacidad para emocionar al público en cada actuación.',
                'city' => 'Córdoba',
                'rehearsal_space' => 'Calle de la Cruz, 12, 14001',
                'email' => 'veracruz@banda.com'
            ],
            [
                'name' => 'Banda de Música de la Redención',
                'description' => 'La Banda de Música de la Redención nace de la unión de músicos apasionados por la música procesional, con el objetivo de ofrecer un estilo propio basado en la fuerza, la sensibilidad y la precisión. A lo largo de su trayectoria, ha participado en numerosos actos y procesiones, consolidándose como una formación dinámica y en constante evolución.',
                'city' => 'Cádiz',
                'rehearsal_space' => 'Avenida de la Constitución, 14, 11001',
                'email' => 'redencion@banda.com'
            ],
            [
                'name' => 'Banda de Música Maestro Tejera',
                'description' => 'La Banda de Música Maestro Tejera es una formación que rinde homenaje al legado musical de grandes compositores, combinando tradición y excelencia interpretativa. Su estilo se caracteriza por la riqueza de matices, la disciplina de sus componentes y un repertorio cuidadosamente seleccionado que abarca desde piezas clásicas hasta composiciones actuales.',
                'city' => 'Málaga',
                'rehearsal_space' => 'Callejón de la Vera Cruz, 5, 29001',
                'email' => 'maestrotejera@banda.com'
            ],
            [
                'name' => 'Banda de Música de la Virgen de los Dolores',
                'description' => 'La Banda de Música de la Virgen de los Dolores es una formación profundamente vinculada a la devoción y a las tradiciones locales, destacando por su sensibilidad interpretativa y su cercanía con el público. Su repertorio está centrado en marchas procesionales de gran carga emocional, interpretadas con solemnidad y respeto.',
                'city' => 'Jaén',
                'rehearsal_space' => 'Plaza de la Magdalena, 7, 23001',
                'email' => 'dolores@banda.com'
            ],
        ];

        foreach ($bandsData as $data) {
            // Crear la banda en la base de datos
            $band = Band::create($data);

            // Crear la cuenta Stripe asociada a la banda
            $stripeAccount = $stripe->accounts->create([
                'type' => 'express',
                'email' => $band->email,
                'business_type' => 'company',
                'company' => [
                    'name' => $band->name,
                ],
                'capabilities' => [
                    'card_payments' => ['requested' => true],
                    'transfers' => ['requested' => true],
                ],
            ]);

            // Guardar el ID de Stripe en la banda
            $band->stripe_account_id = $stripeAccount->id;
            $band->save();
        }
    }
}
