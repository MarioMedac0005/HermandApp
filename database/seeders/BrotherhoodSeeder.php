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
        Brotherhood::factory(5)->create();
    }
}
