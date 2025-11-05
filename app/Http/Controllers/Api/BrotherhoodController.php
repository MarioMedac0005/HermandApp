<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrotherhoodRequest;
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
    public function store(BrotherhoodRequest $request)
    {
        $brotherhood = Brotherhood::create($request->validate());

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
    public function update(BrotherhoodRequest $request, Brotherhood $brotherhood)
    {
        $brotherhood->update($request->validate());

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
