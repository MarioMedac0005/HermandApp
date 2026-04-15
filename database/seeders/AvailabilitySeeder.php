<?php

namespace Database\Seeders;

use App\Models\Availability;
use App\Models\Band;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bands = Band::all();

        foreach ($bands as $band) {
            for ($mes = 1; $mes <= 12; $mes++) { 
                $fechas = collect();

                while ($fechas->count() < 7) {
                    $fecha = Carbon::create(null, $mes, rand(1, 28));

                    $fechas->add($fecha->format('Y-m-d'));
                    $fechas = $fechas->unique();
                }

                foreach ($fechas as $fecha) {
                    Availability::create([
                        'band_id' => $band->id,
                        'date' => $fecha,
                        'description' => fake()->text()
                    ]);
                }
            }
        }
    }
}
