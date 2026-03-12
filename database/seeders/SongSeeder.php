<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Band;
use App\Models\Song;

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bands = Band::all();

        foreach ($bands as $band) {
            $songs = [
                [
                    'title' => 'Amarguras',
                    'duration' => '5:30',
                    'url' => 'https://youtu.be/9zjR9Bo5TxQ?si=skC-5efz2f5jpWS_',
                ],
                [
                    'title' => 'La Estrella Sublime',
                    'duration' => '4:20',
                    'url' => 'https://youtu.be/9zjR9Bo5TxQ?si=skC-5efz2f5jpWS_',
                ],
                [
                    'title' => 'Pasan los Campanilleros',
                    'duration' => '3:45',
                    'url' => 'https://youtu.be/9zjR9Bo5TxQ?si=skC-5efz2f5jpWS_',
                ],
                [
                    'title' => 'Rocío',
                    'duration' => '4:15',
                    'url' => 'https://youtu.be/9zjR9Bo5TxQ?si=skC-5efz2f5jpWS_',
                ],
                [
                    'title' => 'Coronación de la Macarena',
                    'duration' => '4:50',
                    'url' => 'https://youtu.be/9zjR9Bo5TxQ?si=skC-5efz2f5jpWS_',
                ],
            ];

            foreach ($songs as $songData) {
                Song::create([
                    ...$songData,
                    'band_id' => $band->id,
                ]);
            }
        }
    }
}
