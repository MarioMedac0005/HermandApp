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

        $javierRuiz = User::create([
            'name' => 'Javier',
            'surname' => 'Ruiz',
            'email' => 'javier.ruiz@davante.es',
            'password' => Hash::make('password'),
            'band_id' => null,
            'brotherhood_id' => null
        ]);

        $javierRuiz->assignRole('admin');

        $pabloSantaella = User::create([
            'name' => 'Pablo',
            'surname' => 'Santaella',
            'email' => 'pablo.santaella@davante.es',
            'password' => Hash::make('password'),
            'band_id' => null,
            'brotherhood_id' => null
        ]);

        $pabloSantaella->assignRole('admin');

        $sergioDiaz = User::create([
            'name' => 'Sergio',
            'surname' => 'Diaz',
            'email' => 'sergio.diaz@davante.es',
            'password' => Hash::make('password'),
            'band_id' => null,
            'brotherhood_id' => null
        ]);

        $sergioDiaz->assignRole('admin');

        $virginiaMilan = User::create([
            'name' => 'Virginia',
            'surname' => 'Diaz',
            'email' => 'virginia.diaz@davante.es',
            'password' => Hash::make('password'),
            'band_id' => null,
            'brotherhood_id' => null
        ]);

        $virginiaMilan->assignRole('admin');
    }
}