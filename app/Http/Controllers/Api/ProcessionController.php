<?php

namespace App\Http\Controllers\Api;

use App\Models\Procession;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProcessionRequest;
use App\Http\Requests\UpdateProcessionRequest;
use App\Http\Resources\ProcessionResource;

class ProcessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try {

            $processions = Procession::paginate(10);

            return ProcessionResource::collection($processions)
                ->additional([
                    'success' => true,
                    'message' => 'Listado de procesiones paginadas obtenido correctamente'
                ])
                ->response()
                ->setStatusCode(200);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al obtener el listado de procesiones',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProcessionRequest $request)
    {

        try {

            $procession = Procession::create($request->validated());

            return (new ProcessionResource($procession))
                ->additional([
                    'success' => true,
                    'message' => 'La procesion ha sido creada correctamente'
                ])
                ->response()
                ->setStatusCode(201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al intentar crear una procesion',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Procession $procession)
    {

        try {

            return (new ProcessionResource($procession))
                ->additional([
                    'success' => true,
                    'message' => 'La procesión ha sido obtenida correctamente',
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al intentar mostrar una banda',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProcessionRequest $request, Procession $procession)
    {

        try {

            $procession->update($request->validated());

            return (new ProcessionResource($procession))
                ->additional([
                    'success' => true,
                    'message' => 'La procesión ha sido actualizada correctamente',
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al intentar actualizar una procesión',
                'error' => $e->getMessage(),
            ], 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Procession $procession)
    {

        try {

            $procession->delete();

            return response()->json([
                'success' => true,
                'message' => 'La procesión ha sido eliminada correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al intentar borrar una procesión',
                'error' => $e->getMessage(),
            ], 500);

        }
    }
}
