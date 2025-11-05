<?php

namespace App\Http\Controllers\Api;

use App\Models\Contract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContractRequest;
use App\Http\Resources\ContractResource;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ContractResource::collection(Contract::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContractRequest $request)
    {
        $contract = Contract::create($request->validate());

        return new ContractResource($contract);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        return new ContractResource($contract);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContractRequest $request, Contract $contract)
    {
        $contract->update($request->validate());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        $contract->delete();

        return response()->json(['message' => 'Contract deleted successfully']);
    }
}
