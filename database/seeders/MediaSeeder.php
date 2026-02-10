<?php

namespace Database\Seeders;

use App\Models\Band;
use App\Models\Media;
use App\Models\Brotherhood;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    public function run(): void
    {
        $hermandadImagenes = [
            'banner' => [
                'fotoHermandad01.jpg',
                'fotoHermandad02.jpg',
                'fotoHermandad03.jpg',
                'fotoHermandad04.jpg',
            ],
            'profile' => [
                'profileHermandad01.jpg',
                'profileHermandad02.jpg',
                'profileHermandad03.jpg',
                'profileHermandad04.jpg',
            ],
            'gallery' => [
                'galleryHermandad01.jpg',
                'galleryHermandad02.jpg',
                'galleryHermandad03.jpg',
            ],
        ];

        $bandaImagenes = [
            'banner' => [
                'fotoBanda01.jpg',
                'fotoBanda02.jpg',
                'fotoBanda03.jpg',
                'fotoBanda04.jpg',
            ],
            'profile' => [
                'profileBanda01.jpg',
                'profileBanda02.jpg',
                'profileBanda03.jpg',
                'profileBanda04.jpg',
            ],
            'gallery' => [
                'galleryBanda01.jpg',
                'galleryBanda02.jpg',
                'galleryBanda03.jpg',
            ],
        ];

        $this->createMediaForModel(
            Brotherhood::all(),
            $hermandadImagenes,
            Brotherhood::class,
            'brotherhoods'
        );

        $this->createMediaForModel(
            Band::all(),
            $bandaImagenes,
            Band::class,
            'bands'
        );
    }

    private function createMediaForModel($models, $imagenesPorCategoria, $modelClass, $basePath)
    {
        $modelIndex = 0;

        foreach ($models as $model) {
            foreach ($imagenesPorCategoria as $category => $imagenes) {

                // Banner y profile → solo 1 imagen
                if (in_array($category, ['banner', 'profile'])) {
                    $imagen = $imagenes[$modelIndex % count($imagenes)];

                    $this->createMedia(
                        $model,
                        $modelClass,
                        $basePath,
                        $category,
                        $imagen
                    );
                }

                // Gallery → múltiples imágenes
                if ($category === 'gallery') {
                    foreach ($imagenes as $imagen) {
                        $this->createMedia(
                            $model,
                            $modelClass,
                            $basePath,
                            $category,
                            $imagen
                        );
                    }
                }
            }

            $modelIndex++;
        }
    }

    private function createMedia($model, $modelClass, $basePath, $category, $imagen)
    {
        Media::create([
            'model_id'   => $model->id,
            'model_type' => $modelClass,
            'path'       => "{$basePath}/{$model->id}/{$category}/{$imagen}",
            'mime_type'  => $this->getMimeType($imagen),
            'category'   => $category,
        ]);
    }

    private function getMimeType($imagen)
    {
        return match (pathinfo($imagen, PATHINFO_EXTENSION)) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png'         => 'image/png',
            'webp'        => 'image/webp',
            default       => 'application/octet-stream',
        };
    }
}
