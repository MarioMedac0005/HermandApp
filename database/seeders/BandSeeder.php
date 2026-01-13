<?php

namespace Database\Seeders;

use App\Models\Band;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Band::create([
            'name' => 'Banda de Música de la Veracruz',
            'city' => 'Córdoba',
            'rehearsal_space' => 'Calle de la Cruz, 12, 14001',
            'email' => 'veracruz@banda.com'
        ]);

        Band::create([
            'name' => 'Banda de Música de la Redención',
            'city' => 'Cádiz',
            'rehearsal_space' => 'Avenida de la Constitución, 14, 11001',
            'email' => 'redencion@banda.com'
        ]);

        Band::create([
            'name' => 'Banda de Música Maestro Tejera',
            'city' => 'Málaga',
            'rehearsal_space' => 'Callejón de la Vera Cruz, 5, 29001',
            'email' => 'maestrotejera@banda.com'
        ]);

        Band::create([
            'name' => 'Banda de Música de la Virgen de los Dolores',
            'city' => 'Jaén',
            'rehearsal_space' => 'Plaza de la Magdalena, 7, 23001',
            'email' => 'dolores@banda.com'
        ]);

        // Band::factory(5)->create();
    }
}
