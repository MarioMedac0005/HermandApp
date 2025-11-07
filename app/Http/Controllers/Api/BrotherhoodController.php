<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrotherhoodRequest;
use App\Http\Requests\UpdateBrotherhoodRequest;
use App\Http\Resources\BrotherhoodResource;
use App\Models\Brotherhood;
use Illuminate\Http\Request;

class BrotherhoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BrotherhoodResource::collection(Brotherhood::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrotherhoodRequest $request)
    {
        $brotherhood = Brotherhood::create($request->validated());

        return new BrotherhoodResource($brotherhood);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brotherhood $brotherhood)
    {
        return new BrotherhoodResource($brotherhood);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrotherhoodRequest $request, Brotherhood $brotherhood)
    {
        $brotherhood->update($request->validated());

        return new BrotherhoodResource($brotherhood);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brotherhood $brotherhood)
    {
        $brotherhood->delete();

        return response()->json(['message' => 'Brotherhood deleted successfully']);
    }
}
