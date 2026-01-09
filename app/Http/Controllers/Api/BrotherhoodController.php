<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrotherhoodRequest;
use App\Http\Requests\UpdateBrotherhoodRequest;
use App\Http\Resources\BrotherhoodResource;
use App\Models\Brotherhood;

class BrotherhoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $brotherhood = Brotherhood::paginate(10);

            return BrotherhoodResource::collection($brotherhood)
                ->additional([
                    'success' => true,
                    'message' => 'Listado de hermandades paginadas obtenido correctamente'
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return $this->errorResponse('Ha ocurrido un error al obtener el listado de hermandades', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrotherhoodRequest $request)
    {
        try {

            $brotherhood = Brotherhood::create($request->validated());

            return (new BrotherhoodResource($brotherhood))
                ->additional([
                    'success' => true,
                    'message' => 'La hermandad ha sido creada correctamente'
                ])
                ->response()
                ->setStatusCode(201);
        } catch (\Exception $e) {
            return $this->errorResponse('Ha ocurrido un error al intentar crear una hermandad', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Brotherhood $brotherhood)
    {
        try {

            return (new BrotherhoodResource($brotherhood))
                ->additional([
                    'success' => true,
                    'message' => 'La hermandad ha sido obtenida correctamente',
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return $this->errorResponse('Ha ocurrido un error al intentar mostrar una hermandad', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrotherhoodRequest $request, Brotherhood $brotherhood)
    {
        try {

            $brotherhood->update($request->validated());

            return (new BrotherhoodResource($brotherhood))
                ->additional([
                    'success' => true,
                    'message' => 'La hermandad ha sido actualizada correctamente',
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return $this->errorResponse('Ha ocurrido un error al intentar actualizar una hermandad', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brotherhood $brotherhood)
    {
        try {

            $brotherhood->delete();

            return response()->json([
                'success' => true,
                'message' => 'La hermandad ha sido eliminada correctamente',
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Ha ocurrido un error al intentar borrar una hermandad', $e->getMessage());
        }
    }
}
