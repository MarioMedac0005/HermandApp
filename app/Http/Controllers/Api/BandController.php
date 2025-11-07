<?php

namespace App\Http\Controllers\Api;

use App\Models\Band;
use Illuminate\Http\Request;
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
        return BandResource::collection(Band::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBandRequest $request)
    {
        $band = Band::create($request->validated());

        return new BandResource($band);
    }

    /**
     * Display the specified resource.
     */
    public function show(Band $band)
    {
        return new BandResource($band);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBandRequest $request, Band $band)
    {
        $band->update($request->validated());

        return new BandResource($band);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Band $band)
    {
        $band->delete();

        return response()->json(['message' => 'Band deleted successfully']);
    }
}
