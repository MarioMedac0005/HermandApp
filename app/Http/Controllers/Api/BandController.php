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

            $band = Band::with('media')->paginate(10);

            /*
                BandResource::collection -> ::collection es un metodo estatico de JsonResource
                se utiliza para devolver una coleccion de datos del modelo.
                    ->additional: Permite agregar informacion adicional a la respuesta.
                    ->response: Convierte el objeto en un objeto listo para enviar.
                    ->setStatusCode: Establece el codigo de respuesta de la peticion.
            */
            return BandResource::collection($band)
                ->additional([
                    'success' => true,
                    'message' => 'Listado de bandas paginadas obtenido correctamente'
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return $this->errorResponse('Ha ocurrido un error al obtener el listado de bandas', $e->getMessage());
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
            return $this->errorResponse('Ha ocurrido un error al intentar crear una banda', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Band $band)
    {
        try {
            $band->load('media');

            return (new BandResource($band))
                ->additional([
                    'success' => true,
                    'message' => 'La banda ha sido obtenida correctamente',
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return $this->errorResponse('Ha ocurrido un error al intentar mostrar una banda', $e->getMessage());
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
            return $this->errorResponse('Ha ocurrido un error al intentar crear una banda', $e->getMessage());
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
            return $this->errorResponse('Ha ocurrido un error al intentar borrar una banda', $e->getMessage());
        }
    }
}
