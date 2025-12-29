<?php

namespace App\Http\Controllers\Api;

use App\Models\Band;
use App\Models\User;
use App\Models\Media;
use App\Models\Brotherhood;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MediaResource;
use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;

class MediaController extends Controller
{

    protected array $allowedModels = [
        'band'        => Band::class,
        'brotherhood' => Brotherhood::class,
        'user'        => User::class,
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $media = Media::paginate(10);

            return MediaResource::collection($media)
                ->additional([
                    'success' => true,
                    'message' => 'Listado de archivos obtenido correctamente'
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al obtener el listado de archivos',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMediaRequest $request)
    {
        try {

            $model = $this->modelAveriguacion($request->model_type, $request->model_id);

            $file = $request->file('file');
            $folder = $this->pathBuilder($model, $request->category);

            $path = $file->store($folder, 'public');
            $mime = $file->getClientMimeType();

            // Categorías únicas
            if (in_array($request->category, ['profile', 'banner'])) {
                $model->media()->where('category', $request->category)->delete();
            }

            $media = $model->media()->create([
                'path'      => $path,
                'mime_type' => $mime,
                'category'  => $request->category,
            ]);

            return (new MediaResource($media))
                ->additional([
                    'success' => true,
                    'message' => 'Archivo subido correctamente'
                ])
                ->response()
                ->setStatusCode(201);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al subir el archivo',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Media $media)
    {
        try {

            return (new MediaResource($media))
                ->additional([
                    'success' => true,
                    'message' => 'Archivo obtenido correctamente',
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el archivo',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMediaRequest $request, Media $media)
    {
        try {

            $model = $media->model;

            if ($request->filled('category') && $request->category !== $media->category) {

                if (in_array($request->category, ['profile', 'banner'])) {
                    $model->media()
                        ->where('category', $request->category)
                        ->where('id', '!=', $media->id)
                        ->delete();
                }

                $media->category = $request->category;
            }

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $folder = $this->pathBuilder($model, $media->category);

                $media->path = $file->store($folder, 'public');
                $media->mime_type = $file->getClientMimeType();
            }

            $media->save();

            return (new MediaResource($media))
                ->additional([
                    'success' => true,
                    'message' => 'Archivo actualizado correctamente',
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el archivo',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        try {

            $media->delete();

            return response()->json([
                'success' => true,
                'message' => 'Archivo eliminado correctamente'
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el archivo',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    protected function modelAveriguacion(string $type, int $id)
    {
        $type = strtolower($type);

        if (!isset($this->allowedModels[$type])) {
            abort(422, 'Invalid model_type');
        }

        return $this->allowedModels[$type]::findOrFail($id);
    }

    protected function pathBuilder($model, string $category)
    {
        return strtolower(class_basename($model)) . 's' . '/' . $model->id . '/' . Str::slug($category);
    }
}
