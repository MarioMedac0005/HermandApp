<?php

namespace Database\Seeders;

use App\Models\Band;
use App\Models\Brotherhood;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Administrador',
            'surname' => 'Sistema',
            'email' => 'admin@arena.com',
            'password' => 'admin123',
            'band_id' => null,
            'brotherhood_id' => null,
        ]);

        $admin->assignRole('admin');

        $gestorBanda = User::create([
            'name' => 'Pepe',
            'surname' => 'Villuela',
            'email' => 'pepe@banda.com',
            'password' => '1234',
            'band_id' => Band::all()->random()->id,
            'brotherhood_id' => null,
        ]);

        $gestorBanda->assignRole('gestor');

        $gestorHermandad = User::create([
            'name' => 'Lionel',
            'surname' => 'Andrés Messi Cuccittini',
            'email' => 'messi@hermandad.com',
            'password' => '1234',
            'band_id' => null,
            'brotherhood_id' => Brotherhood::all()->random()->id,
        ]);

        $gestorHermandad->assignRole('gestor');
    }
}
