<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Procession;
use App\Models\Segment;
use App\Models\PointOfInterest;

class ProcessionSeeder extends Seeder
{
    public function run(): void
    {
        $processions = [

            // =========================
            // 📍 CÓRDOBA
            // =========================
            [
                'name' => 'Cristo de la Luz',
                'segments' => [
                    ['name'=>'Salida','color'=>'#FF5733','coords'=>[[-4.7794,37.8796],[-4.7796,37.8800]]],
                    ['name'=>'Cardenal Herrero','color'=>'#FF5733','coords'=>[[-4.7796,37.8800],[-4.7800,37.8805]]],
                    ['name'=>'Magistral','color'=>'#FF5733','coords'=>[[-4.7800,37.8805],[-4.7806,37.8810]]],
                    ['name'=>'Tendillas','color'=>'#FF5733','coords'=>[[-4.7806,37.8810],[-4.7815,37.8820]]],
                    ['name'=>'Gondomar','color'=>'#FF5733','coords'=>[[-4.7815,37.8820],[-4.7820,37.8825]]],
                    ['name'=>'Diario Córdoba','color'=>'#FF5733','coords'=>[[-4.7820,37.8825],[-4.7815,37.8830]]],
                    ['name'=>'Regreso 1','color'=>'#FF5733','coords'=>[[-4.7815,37.8830],[-4.7805,37.8825]]],
                    ['name'=>'Regreso 2','color'=>'#FF5733','coords'=>[[-4.7805,37.8825],[-4.7795,37.8815]]],
                ],
                'pois' => [
                    ['name'=>'Mezquita','lat'=>37.8796,'lng'=>-4.7794],
                    ['name'=>'Tendillas','lat'=>37.8820,'lng'=>-4.7815],
                ]
            ],

            // =========================
            // 📍 SEVILLA
            // =========================
            [
                'name' => 'Virgen de los Reyes',
                'segments' => [
                    ['name'=>'Salida Catedral','color'=>'#059669','coords'=>[[-5.9923,37.3867],[-5.9919,37.3871]]],
                    ['name'=>'Av Constitución','color'=>'#059669','coords'=>[[-5.9919,37.3871],[-5.9912,37.3876]]],
                    ['name'=>'Archivo Indias','color'=>'#059669','coords'=>[[-5.9912,37.3876],[-5.9906,37.3880]]],
                    ['name'=>'Santa Cruz 1','color'=>'#059669','coords'=>[[-5.9906,37.3880],[-5.9900,37.3883]]],
                    ['name'=>'Santa Cruz 2','color'=>'#059669','coords'=>[[-5.9900,37.3883],[-5.9894,37.3880]]],
                    ['name'=>'Plaza','color'=>'#059669','coords'=>[[-5.9894,37.3880],[-5.9890,37.3875]]],
                    ['name'=>'Regreso 1','color'=>'#059669','coords'=>[[-5.9890,37.3875],[-5.9900,37.3869]]],
                    ['name'=>'Entrada','color'=>'#059669','coords'=>[[-5.9900,37.3869],[-5.9923,37.3867]]],
                ],
                'pois' => [
                    ['name'=>'Catedral','lat'=>37.3867,'lng'=>-5.9923],
                    ['name'=>'Santa Cruz','lat'=>37.3882,'lng'=>-5.9902],
                ]
            ],

            // =========================
            // 📍 MÁLAGA
            // =========================
            [
                'name' => 'Cristo de la Sangre',
                'segments' => [
                    ['name'=>'Salida','color'=>'#2563EB','coords'=>[[-4.4214,36.7213],[-4.4218,36.7210]]],
                    ['name'=>'Molina Lario','color'=>'#2563EB','coords'=>[[-4.4218,36.7210],[-4.4225,36.7207]]],
                    ['name'=>'Alameda 1','color'=>'#2563EB','coords'=>[[-4.4225,36.7207],[-4.4232,36.7204]]],
                    ['name'=>'Alameda 2','color'=>'#2563EB','coords'=>[[-4.4232,36.7204],[-4.4238,36.7200]]],
                    ['name'=>'Larios','color'=>'#2563EB','coords'=>[[-4.4238,36.7200],[-4.4230,36.7195]]],
                    ['name'=>'Centro','color'=>'#2563EB','coords'=>[[-4.4230,36.7195],[-4.4220,36.7192]]],
                    ['name'=>'Regreso','color'=>'#2563EB','coords'=>[[-4.4220,36.7192],[-4.4215,36.7202]]],
                    ['name'=>'Entrada','color'=>'#2563EB','coords'=>[[-4.4215,36.7202],[-4.4214,36.7213]]],
                ],
                'pois' => [
                    ['name'=>'Catedral','lat'=>36.7213,'lng'=>-4.4214],
                    ['name'=>'Calle Larios','lat'=>36.7198,'lng'=>-4.4235],
                ]
            ],

            // =========================
            // 📍 GRANADA
            // =========================
            [
                'name' => 'Virgen de la Esperanza',
                'segments' => [
                    ['name'=>'Salida','color'=>'#FBBF24','coords'=>[[-3.5987,37.1765],[-3.5993,37.1770]]],
                    ['name'=>'Gran Vía','color'=>'#FBBF24','coords'=>[[-3.5993,37.1770],[-3.6000,37.1775]]],
                    ['name'=>'Subida 1','color'=>'#FBBF24','coords'=>[[-3.6000,37.1775],[-3.6008,37.1780]]],
                    ['name'=>'Subida 2','color'=>'#FBBF24','coords'=>[[-3.6008,37.1780],[-3.6015,37.1785]]],
                    ['name'=>'Albaicín','color'=>'#FBBF24','coords'=>[[-3.6015,37.1785],[-3.6020,37.1790]]],
                    ['name'=>'Mirador','color'=>'#FBBF24','coords'=>[[-3.6020,37.1790],[-3.6025,37.1795]]],
                    ['name'=>'Regreso','color'=>'#FBBF24','coords'=>[[-3.6025,37.1795],[-3.6010,37.1780]]],
                    ['name'=>'Entrada','color'=>'#FBBF24','coords'=>[[-3.6010,37.1780],[-3.5987,37.1765]]],
                ],
                'pois' => [
                    ['name'=>'Catedral','lat'=>37.1765,'lng'=>-3.5987],
                    ['name'=>'San Nicolás','lat'=>37.1795,'lng'=>-3.6025],
                ]
            ],
        ];

        foreach ($processions as $data) {

            $procession = Procession::factory()->create([
                'name' => $data['name']
            ]);

            $points = 0;

            foreach ($data['segments'] as $seg) {

                Segment::create([
                    'procession_id' => $procession->id,
                    'name' => $seg['name'],
                    'color' => $seg['color'],
                    'width' => 5,
                    'visible' => 1,
                    'coordinates' => $seg['coords'],
                ]);

                $points += count($seg['coords']);
            }

            foreach ($data['pois'] as $poi) {

                PointOfInterest::create([
                    'procession_id' => $procession->id,
                    'name' => $poi['name'],
                    'lat' => $poi['lat'],
                    'lng' => $poi['lng'],
                    'icon' => 'marker',
                    'color' => '#2563eb',
                    'show_label' => 1,
                    'image_url' => 'https://via.placeholder.com/640x480.png'
                ]);

                $points++;
            }

            $procession->update([
                'points_count' => $points
            ]);
        }
    }
}
