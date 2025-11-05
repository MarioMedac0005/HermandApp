<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AvailabilityRequest;
use App\Http\Resources\AvailabilityResource;
use App\Models\Availability;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AvailabilityResource::collection(Availability::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AvailabilityRequest $request)
    {
        $availability = Availability::create($request->validate());

        return new AvailabilityResource($availability);
    }

    /**
     * Display the specified resource.
     */
    public function show(Availability $availability)
    {
        return new AvailabilityResource($availability);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AvailabilityRequest $request, Availability $availability)
    {
        $availability->update($request->validate());

        return new AvailabilityResource($availability);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Availability $availability)
    {
        $availability->delete();

        return response()->json(['message' => 'availability deleted successfully']);
    }
}
