<?php

namespace App\Http\Controllers\Api;

use App\Models\Procession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessionRequest;
use App\Http\Resources\ProcessionResource;

class ProcessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProcessionResource::collection(Procession::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProcessionRequest $request)
    {
        $procession = Procession::create($request->validate());

        return new ProcessionResource($procession);
    }

    /**
     * Display the specified resource.
     */
    public function show(Procession $procession)
    {
        return new ProcessionResource($procession);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProcessionRequest $request, Procession $procession)
    {
        $procession->update($request->validate());

        return new ProcessionResource($procession);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Procession $procession)
    {
        $procession->delete();

         return response()->json(['message' => 'Procession deleted successfully']);

    }
}
