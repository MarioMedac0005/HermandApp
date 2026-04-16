<?php

namespace App\Http\Controllers\Api;

use App\Models\Procession;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProcessionRequest;
use App\Http\Requests\UpdateProcessionRequest;
use App\Http\Resources\ProcessionResource;
use Illuminate\Support\Facades\Storage;

class ProcessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $user = auth('sanctum')->user();
            $query = Procession::query();

            // Si es gestor de hermandad, solo ve las de su hermandad por defecto
            if ($user && $user->brotherhood_id) {
                $query->where('brotherhood_id', $user->brotherhood_id);
            }
            // Si viene brotherhood_id por query (para perfil público)
            elseif (request()->has('brotherhood_id')) {
                $query->where('brotherhood_id', request()->query('brotherhood_id'));

                // En perfil público solo vemos publicadas a menos que seas el dueño o admin
                if (!$user || (!$user->hasRole('admin') && $user->brotherhood_id != request()->query('brotherhood_id'))) {
                    $query->where('status', 'published');
                }
            }
            // Si no hay filtros específicos y no es admin, solo vemos publicadas
            elseif (!$user || !$user->hasRole('admin')) {
                $query->where('status', 'published');
            }

            // Filtro por nombre (búsqueda)
            $searchTerm = request()->query('search');
            $status = request()->query('status');
            $sort = request()->query('sort'); // 'recent', 'oldest'

            if ($searchTerm) {
                $query->where('name', 'LIKE', "%{$searchTerm}%");
            }

            if ($status) {
                $query->where('status', $status);
            }

            if ($sort === 'oldest') {
                $query->orderBy('checkout_time', 'asc');
            } else {
                $query->orderBy('checkout_time', 'desc');
            }

            $processions = $query->with(['brotherhood', 'segments', 'pointsOfInterest'])->paginate(6);

            return ProcessionResource::collection($processions)
                ->additional([
                    'success' => true,
                    'message' => 'Listado de procesiones paginadas obtenido correctamente'
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return $this->errorResponse('Ha ocurrido un error al obtener el listado de procesiones', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProcessionRequest $request)
    {
        try {
            return \DB::transaction(function () use ($request) {
                $procession = Procession::create($request->validated());

                $this->syncMapData($procession, $request);

                if ($request->hasFile('preview')) {
                    $this->handlePreviewUpload($procession, $request->file('preview'));
                }

                return (new ProcessionResource($procession->load(['brotherhood', 'segments', 'pointsOfInterest'])))
                    ->additional([
                        'success' => true,
                        'message' => 'La procesion ha sido creada correctamente'
                    ])
                    ->response()
                    ->setStatusCode(201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al intentar crear una procesion',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Procession $procession)
    {
        try {
            $user = auth('sanctum')->user();

            // Si es borrador, solo el dueño (mismo brotherhood_id) o un admin pueden verla
            if ($procession->status === 'draft') {
                if (!$user || (!$user->hasRole('admin') && $user->brotherhood_id != $procession->brotherhood_id)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Esta procesión todavía no ha sido publicada',
                    ], 403);
                }
            }

            return (new ProcessionResource($procession->load(['brotherhood', 'segments', 'pointsOfInterest'])))
                ->additional([
                    'success' => true,
                    'message' => 'La procesión ha sido obtenida correctamente',
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al intentar mostrar la procesión',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProcessionRequest $request, Procession $procession)
    {
        try {
            return \DB::transaction(function () use ($request, $procession) {
                $procession->update($request->validated());

                $this->syncMapData($procession, $request);

                if ($request->hasFile('preview')) {
                    $this->handlePreviewUpload($procession, $request->file('preview'));
                }

                return (new ProcessionResource($procession->load(['brotherhood', 'segments', 'pointsOfInterest'])))
                    ->additional([
                        'success' => true,
                        'message' => 'La procesión ha sido actualizada correctamente',
                    ])
                    ->response()
                    ->setStatusCode(200);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al intentar actualizar una procesión',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Sincroniza los tramos y puntos de interés de una procesión.
     */
    private function syncMapData(Procession $procession, $request)
    {
        if ($request->has('tramos')) {
            $procession->segments()->delete();
            foreach ($request->tramos as $segmentData) {
                // Ensure coordinates are present
                if (!isset($segmentData['coordinates']))
                    continue;

                $procession->segments()->create([
                    'name' => $segmentData['name'],
                    'color' => $segmentData['color'] ?? '#9333ea',
                    'width' => $segmentData['width'] ?? 5,
                    'visible' => $segmentData['visible'] ?? true,
                    'coordinates' => $segmentData['coordinates']
                ]);
            }
        }

        if ($request->has('points') || $request->has('puntos')) {
            $points = $request->input('points') ?? $request->input('puntos');
            $procession->pointsOfInterest()->delete();
            foreach ($points as $pointData) {
                $procession->pointsOfInterest()->create([
                    'name' => $pointData['name'],
                    'description' => $pointData['description'] ?? null,
                    'lat' => $pointData['lat'],
                    'lng' => $pointData['lng'],
                    'image_url' => $pointData['image_url'] ?? $pointData['imageUrl'] ?? null,
                    'icon' => $pointData['icon'] ?? 'default',
                    'color' => $pointData['color'] ?? '#9333ea',
                    'show_label' => $pointData['show_label'] ?? $pointData['showLabel'] ?? true,
                ]);
            }
        }
    }


    /**
     * Save the preview image file.
     */
    private function handlePreviewUpload(Procession $procession, $file)
    {
        $extension = $file->getClientOriginalExtension();
        $path = 'processions/' . $procession->id . '_preview.' . $extension;

        // Delete old preview if exists
        if ($procession->preview_url) {
            $oldPath = str_replace(url('storage') . '/', '', $procession->preview_url);
            Storage::disk('public')->delete($oldPath);
        }

        Storage::disk('public')->put($path, file_get_contents($file));

        $procession->update([
            'preview_url' => url('storage/' . $path)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Procession $procession)
    {
        try {
            // Delete preview image from storage before removing the record
            if ($procession->preview_url) {
                $oldPath = str_replace(url('storage') . '/', '', $procession->preview_url);
                Storage::disk('public')->delete($oldPath);
            }

            $procession->delete();

            return response()->json([
                'success' => true,
                'message' => 'La procesión ha sido eliminada correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al intentar borrar una procesión',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
