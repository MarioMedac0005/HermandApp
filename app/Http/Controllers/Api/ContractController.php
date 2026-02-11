<?php

namespace App\Http\Controllers\Api;

use App\Models\Availability;
use App\Models\Band;
use App\Models\Contract;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;
use App\Http\Resources\ContractResource;
use App\Services\PdfService;
use Auth;
use Carbon\Carbon;
use DB;

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

            $contract = Contract::create($request->validated());

            return (new ContractResource($contract))
                ->additional([
                    'success' => true,
                    'message' => 'La contratos ha sido creada correctamente'
                ])
                ->response()
                ->setStatusCode(201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al intentar crear una contratos',
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
        try {
            $user = Auth::user();

            // 1# Pertenece el usuario a la banda del contrato que quiere aceptar.
            if ($user->band_id !== $contract->band_id) {
                return $this->errorResponse(
                    'No puedes aceptar este contrato',
                    'No pertenece el usuario a la banda del contrato que quiere aceptar.'
                );
            }

            // 2# Validar el estado del contrato.
            if ($contract->status !== 'pending') {
                return $this->errorResponse(
                    'No puedes aceptar este contrato',
                    'El contrato no se encuentra en estado pendiente.'
                );
            }

            // 3# Verificar que la banda no esta ocupada el dia especificado en el contrato.
            $fechaInicio = Carbon::parse($contract->date)->startOfDay();
            $fechaFin = Carbon::parse($contract->date)->endOfDay();

            $existe = Availability::where('band_id', $contract->band_id)
                ->whereBetween('date', [$fechaInicio, $fechaFin])
                ->exists();

            if ($existe) {
                return $this->errorResponse(
                    'No puedes aceptar este contrato',
                    'La banda ya tiene un contrato en la fecha especificada.'
                );
            }

            // # Transaccion para crear registros.
            DB::transaction(function () use ($contract) {
                
                // 1# Actualizar el estado del contrato.
                $contract->update([
                    'status' => 'accepted'
                ]);

                // 2# Crear disponibilidad.
                Availability::create([
                    'band_id' => $contract->band_id,
                    'date' => $contract->date,
                    'description' => 'Contrato #' . $contract->id,
                ]);

                // TODO: Generar el contrato en PDF
                $pdfService = new PdfService();
                $pdf = $pdfService->generateContract($contract);

                $filename = 'contracts/contract_' . $contract->id . '.pdf';
                $pdf->save(storage_path('app/public/' . $filename));

                $contract->pdf_path = $filename;
                $contract->save();

            });

            return response()->json([
                'success' => true,
                'message' => 'Contrato aceptado correctamente',
            ], 200);

            
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Ha ocurrido un error al intentar aceptar el contrato',
                $th->getMessage()
            );
        }
    }

    public function reject(Contract $contract)
    {
        try {
            $user = Auth::user();

            // 1# Pertenece el usuario a la banda del contrato que quiere rechazar.
            if ($user->band_id !== $contract->band_id) {
                return $this->errorResponse(
                    'No puedes rechazar este contrato',
                    'No pertenece el usuario a la banda del contrato que quiere rechazar.'
                );
            }

            // 2# Validar el estado del contrato.
            if ($contract->status !== 'pending') {
                return $this->errorResponse(
                    'No puedes aceptar este contrato',
                    'El contrato no se encuentra en estado pendiente.'
                );
            }

            $contract->update([
                'status' => 'rejected'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Contrato rechazado correctamente'
            ], 200);
            
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Ha ocurrido un error al intentar rechazar el contrato',
                $th->getMessage()
            );
        }
    }
}
