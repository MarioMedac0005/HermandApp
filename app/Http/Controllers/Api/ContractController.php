<?php

namespace App\Http\Controllers\Api;

use App\Models\Contract;
use App\Models\Procession;
use App\Models\Availability;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContractResource;
use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $contract = Contract::paginate(10);

            return ContractResource::collection($contract)
                ->additional([
                    'success' => true,
                    'message' => 'Listado de contratos paginadas obtenido correctamente'
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al obtener el listado de contratos',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(StoreContractRequest $request)
{
    try {
        $procession = Procession::findOrFail($request->procession_id);

        $contract = Contract::create([
            'date' => $request->date,
            'status' => 'pending',
            'amount' => $request->amount,
            'description' => $request->description,
            'band_id' => $request->band_id,
            'procession_id' => $request->procession_id,
            'brotherhood_id' => $procession->brotherhood_id,
        ]);

        return (new ContractResource($contract))
            ->additional([
                'success' => true,
                'message' => 'Contrato enviado correctamente (pending)'
            ])
            ->response()
            ->setStatusCode(201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error creando contrato',
            'error' => $e->getMessage(),
        ], 500);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        try {

            return (new ContractResource($contract))
                ->additional([
                    'success' => true,
                    'message' => 'La contratos ha sido obtenida correctamente',
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return $this->errorResponse('Ha ocurrido un error al intentar mostrar una contratos', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractRequest $request, Contract $contract)
    {
        try {

            $contract->update($request->validated());

            return (new ContractResource($contract))
                ->additional([
                    'success' => true,
                    'message' => 'La contratos ha sido actualizada correctamente',
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return $this->errorResponse('Ha ocurrido un error al intentar crear una contratos', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        try {

            $contract->delete();

            return response()->json([
                'success' => true,
                'message' => 'La contrato ha sido eliminada correctamente',
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Ha ocurrido un error al intentar borrar una contrato', $e->getMessage());
        }
    }
    public function accept(Contract $contract)
{
    return DB::transaction(function () use ($contract) {

        $contract = Contract::whereKey($contract->id)->lockForUpdate()->first();

        if ($contract->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Solo se pueden aceptar contratos en estado pending'
            ], 409);
        }

        // 1) Verificar banda libre (en availabilities)
        $bandBusy = Availability::where('band_id', $contract->band_id)
            ->where('date', $contract->date)
            ->where('status', 'occupied')
            ->exists();

        if ($bandBusy) {
            return response()->json([
                'success' => false,
                'message' => 'La banda ya está ocupada en esa fecha/hora'
            ], 409);
        }

        // 2) Verificar hermandad libre SIN availability:
        // inferimos por contratos active en esa misma fecha/hora
        $brotherhoodBusy = Contract::where('brotherhood_id', $contract->brotherhood_id)
            ->where('date', $contract->date)
            ->where('status', 'active')
            ->exists();

        if ($brotherhoodBusy) {
            return response()->json([
                'success' => false,
                'message' => 'La hermandad ya tiene un contrato activo en esa fecha/hora'
            ], 409);
        }

        // 3) Activar contrato
        $contract->update(['status' => 'active']);

        Availability::updateOrCreate(
            ['band_id' => $contract->band_id, 'date' => $contract->date],
            ['status' => 'occupied', 'description' => 'Ocupado por contrato #' . $contract->id]
        );

        return (new ContractResource($contract))
            ->additional([
                'success' => true,
                'message' => 'Contrato aceptado: banda ocupada y hermandad no disponible (inferido por contrato activo)'
            ])
            ->response()
            ->setStatusCode(200);
    });
}

public function reject(Contract $contract)
{
    return DB::transaction(function () use ($contract) {

        $contract = Contract::whereKey($contract->id)->lockForUpdate()->first();

        if ($contract->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Solo se pueden rechazar contratos en estado pending'
            ], 409);
        }

        $contract->update(['status' => 'expired']);

        return (new ContractResource($contract))
            ->additional([
                'success' => true,
                'message' => 'Contrato rechazado correctamente'
            ])
            ->response()
            ->setStatusCode(200);
    });
}

}

