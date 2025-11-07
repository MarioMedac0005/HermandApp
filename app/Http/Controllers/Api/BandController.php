<?php

namespace App\Http\Controllers\Api;

use App\Models\Band;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBandRequest;
use App\Http\Requests\UpdateBandRequest;
use App\Http\Resources\BandResource;

class BandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $band = Band::paginate(10);

            return BandResource::collection($band)
                ->additional([
                    'success' => true,
                    'message' => 'Listado de bandas paginadas obtenido correctamente'
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al obtener el listado de bandas',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBandRequest $request)
    {

        try {

            $band = Band::create($request->validated());

            return (new BandResource($band))
                ->additional([
                    'success' => true,
                    'message' => 'La banda ha sido creada correctamente'
                ])
                ->response()
                ->setStatusCode(201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al intentar crear una banda',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Band $band)
    {
        try {

            return (new BandResource($band))
                ->additional([
                    'success' => true,
                    'message' => 'La banda ha sido obtenida correctamente',
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
    public function update(UpdateBandRequest $request, Band $band)
    {
        try {

            $band->update($request->validated());

            return (new BandResource($band))
                ->additional([
                    'success' => true,
                    'message' => 'La banda ha sido actualizada correctamente',
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al intentar crear una banda',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Band $band)
    {
        try {

            $band->delete();

            return response()->json([
                'success' => true,
                'message' => 'La banda ha sido eliminada correctamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al intentar borrar una banda',
                'error' => $e->getMessage(),
            ], 500);

        }
    }
}
