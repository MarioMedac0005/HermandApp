<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAvailabilityRequest;
use App\Http\Requests\UpdateAvailabilityRequest;
use App\Http\Resources\AvailabilityResource;
use App\Models\Availability;
use App\Models\Band;
use Carbon\Carbon;

class AvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $availability = Availability::paginate(10);

            return AvailabilityResource::collection($availability)
                ->additional([
                    'success' => true,
                    'message' => 'Listado de disponibilidad paginadas obtenido correctamente'
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return $this->errorResponse('Ha ocurrido un error al obtener el listado de disponibilidad', $e->getMessage());
        }
    }

    public function getBookedDates(Band $band)
    {
        try {
            $dates = Availability::where('band_id', $band->id)
                ->where('status', 'occupied')
                ->pluck('date')
                ->map(fn ($date) => Carbon::parse($date)->format('Y-m-d'))
                ->values();

            return $this->successResponse(
                'Días ocupados recuperados correctamente',
                $dates
            );

        } catch (\Exception $e) {
            return $this->errorResponse(
                'Ha ocurrido un error al obtener las fechas reservadas',
                $e->getMessage()
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAvailabilityRequest $request)
    {
        try {

            $availability = Availability::create($request->validated());

            return (new AvailabilityResource($availability))
                ->additional([
                    'success' => true,
                    'message' => 'La disponibilidad ha sido creada correctamente'
                ])
                ->response()
                ->setStatusCode(201);
        } catch (\Exception $e) {
            return $this->errorResponse('Ha ocurrido un error al intentar crear una disponibilidad', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Availability $availability)
    {
        try {

            return (new AvailabilityResource($availability))
                ->additional([
                    'success' => true,
                    'message' => 'La disponibilidad ha sido obtenida correctamente',
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return $this->errorResponse('Ha ocurrido un error al intentar mostrar una disponibilidad', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAvailabilityRequest $request, Availability $availability)
    {
        try {

            $availability->update($request->validated());

            return (new AvailabilityResource($availability))
                ->additional([
                    'success' => true,
                    'message' => 'La disponibilidad ha sido actualizada correctamente',
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return $this->errorResponse('Ha ocurrido un error al intentar crear una disponibilidad', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Availability $availability)
    {
        try {

            $availability->delete();

            return response()->json([
                'success' => true,
                'message' => 'La disponibilidad ha sido eliminada correctamente',
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Ha ocurrido un error al intentar borrar una disponibilidad', $e->getMessage());
        }
    }
}
