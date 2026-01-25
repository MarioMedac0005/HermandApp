<?php

namespace Database\Seeders;

use App\Models\Band;
use App\Models\Brotherhood;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mario = User::create([
            'name' => 'Mario',
            'surname' => 'Ortiz Hidalgo',
            'email' => 'moh0005@alu.medac.es',
            'password' => Hash::make('Usuario123'),
            'band_id' => null,
            'brotherhood_id' => null,
        ]);

        $mario->assignRole('admin');

        $gonzalo = User::create([
            'name' => 'Gonzalo',
            'surname' => 'Martínez de la torre',
            'email' => 'gmt0009@alu.medac.es',
            'password' => Hash::make('Usuario123'),
            'band_id' => null,
            'brotherhood_id' => null,
        ]);

        $gonzalo->assignRole('admin');

        $iraida = User::create([
            'name' => 'Iraida',
            'surname' => 'Romero Conde',
            'email' => 'irc0009@alu.medac.es',
            'password' => Hash::make('Usuario123'),
            'band_id' => null,
            'brotherhood_id' => null,
        ]);

        $iraida->assignRole('admin');

        $alfonso = User::create([
            'name' => 'Alfonso',
            'surname' => 'Carmona Aguayo',
            'email' => 'aca0079@alu.medac.es',
            'password' => Hash::make('Usuario123'),
            'band_id' => null,
            'brotherhood_id' => null,
        ]);

        $alfonso->assignRole('admin');

        $adminBanda = User::create([
            'name' => 'Admin',
            'surname' => 'Banda',
            'email' => 'adminbanda@banda.com',
            'password' => Hash::make('Usuario123'),
            'band_id' => Band::all()->random()->id,
            'brotherhood_id' => null,
        ]);

        $adminBanda->assignRole('gestor');

        $adminHermandad = User::create([
            'name' => 'Admin',
            'surname' => 'Hermandad',
            'email' => 'adminhermandad@hermandad.com',
            'password' => Hash::make('Usuario123'),
            'band_id' => null,
            'brotherhood_id' => Brotherhood::all()->random()->id,
        ]);

        $adminHermandad->assignRole('gestor');
    }
}