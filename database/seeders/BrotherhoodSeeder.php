<?php

namespace Database\Seeders;

use App\Models\Brotherhood;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class BrotherhoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Brotherhood::create([
            'name' => 'Hermandad de la Esperanza',
            'city' => 'Sevilla',
            'office' => 'Calle de la Esperanza, 15, 41004',
            'phone_number' => '954123456',
            'email' => 'esperanza@hermandad.com'
        ]);

        Brotherhood::create([
            'name' => 'Hermandad del Gran Poder',
            'city' => 'Córdoba',
            'office' => 'Plaza del Gran Poder, 4, 14002',
            'phone_number' => '954654321',
            'email' => 'granpoder@hermandad.com'
        ]);

        Brotherhood::create([
            'name' => 'Hermandad de la Macarena',
            'city' => 'Sevilla',
            'office' => 'Calle de la Macarena, 18, 41002',
            'phone_number' => '954987654',
            'email' => 'macarena@hermandad.com'
        ]);

        Brotherhood::create([
            'name' => 'Hermandad de la Virgen de los Dolores',
            'city' => 'Málaga',
            'office' => 'Avenida de los Dolores, 7, 29001',
            'phone_number' => '952345678',
            'email' => 'dolores@hermandad.com'
        ]);

        // Brotherhood::factory(5)->create();
    }
}
