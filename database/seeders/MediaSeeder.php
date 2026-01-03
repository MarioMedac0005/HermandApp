<?php

namespace Database\Seeders;

use App\Models\Band;
use App\Models\Media;
use App\Models\Brotherhood;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Definimos las imágenes para hermandades y bandas
        $hermandadImagenes = [
            'fotoHermandad01.jpg',
            'fotoHermandad02.jpg',
            'fotoHermandad03.jpg',
            'fotoHermandad04.jpg',
        ];

        $bandaImagenes = [
            'fotoBanda01.jpeg',
            'fotoBanda02.jpg',
            'fotoBanda03.jpg',
            'fotoBanda04.jpg',
        ];

        // Asignar una imagen a cada hermandad
        $this->createMediaForModel(Brotherhood::all(), $hermandadImagenes, 'brotherhoods');

        // Asignar una imagen a cada banda
        $this->createMediaForModel(Band::all(), $bandaImagenes, 'bands');
    }

    /**
     * Método general para crear los medios para cualquier modelo.
     */
    private function createMediaForModel($modelCollection, $imagenes, $modelType)
    {
        $category = 'banner';
        $index = 0;  // Para controlar el índice de las imágenes

        foreach ($modelCollection as $model) {
            // Asignar una imagen a cada modelo
            Media::create([
                'model_id' => $model->id,
                'model_type' => $modelType === 'brotherhoods' ? Brotherhood::class : Band::class,
                'path' => $modelType . '/' . ($index + 1) . '/' . $category . '/' . $imagenes[$index],
                'mime_type' => $this->getMimeType($imagenes[$index]),
                'category' => $category,
            ]);

            // Aseguramos que el índice no se pase del número de imágenes disponibles
            $index = ($index + 1) % count($imagenes);
        }
    }

    /**
     * Obtener el mime type según la extensión del archivo
     */
    private function getMimeType($imagen)
    {
        $extension = pathinfo($imagen, PATHINFO_EXTENSION);

        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                return 'image/jpeg';
            case 'webp':
                return 'image/webp';
            case 'png':
                return 'image/png';
            default:
                return 'application/octet-stream';
        }
    }
}
