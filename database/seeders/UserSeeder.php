<?php

namespace Database\Seeders;

use App\Models\Band;
use App\Models\Brotherhood;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([

            'name' => 'Mario',
            'surname' => 'Ortiz Hidalgo',
            'email' => 'mario@gmail.medac.com',
            'password' => Hash::make('1234'),
            'band_id' => Band::all()->random()->id,
            'brotherhood_id' => Brotherhood::all()->random()->id

        ]);

         User::create([

            'name' => 'Iraida',
            'surname' => 'Romero Conde',
            'email' => 'iraida@gmail.medac.com',
            'password' => Hash::make('1234'),
            'band_id' => Band::all()->random()->id,
            'brotherhood_id' => Brotherhood::all()->random()->id

         ]);

        User::create([

            'name' => 'Alfonso',
            'surname' => 'Carmona Aguayo ',
            'email' => 'alfonso@gmail.medac.com',
            'password' => Hash::make('1234'),
            'band_id' => Band::all()->random()->id,
            'brotherhood_id' => Brotherhood::all()->random()->id

        ]);

        User::create([

            'name' => 'Gonzalo',
            'surname' => 'Martínez de la Torre ',
            'email' => 'gonzalo@gmail.medac.com',
            'password' => Hash::make('1234'),
            'band_id' => Band::all()->random()->id,
            'brotherhood_id' => Brotherhood::all()->random()->id

        ]);

        User::factory(5)->create();

        
        
    }
}
