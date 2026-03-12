<?php

namespace App\Http\Controllers\Api;

use App\Models\Song;
use App\Models\Band;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Band $band)
    {
        $songs = $band->songs()->orderBy('title')->get();
        return response()->json(['data' => $songs]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'duration' => 'nullable|string|max:10',
            'url' => 'nullable|url',
        ]);

        $user = Auth::user();
        
        if (!$user->band_id) {
            return response()->json(['message' => 'El usuario no tiene una banda asignada.'], 403);
        }

        $song = Song::create([
            'title' => $request->title,
            'duration' => $request->duration,
            'url' => $request->url,
            'band_id' => $user->band_id
        ]);

        return response()->json(['data' => $song], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Song $repertoire)
    {
        $user = Auth::user();

        if ($repertoire->band_id !== $user->band_id) {
            return response()->json(['message' => 'No tienes permiso para editar esta canción.'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:100',
            'duration' => 'nullable|string|max:10',
            'url' => 'nullable|url',
        ]);

        $repertoire->update($request->only(['title', 'duration', 'url']));

        return response()->json(['data' => $repertoire]);
    }

    public function destroy(Song $repertoire)
    {
        $user = Auth::user();

        if ($repertoire->band_id !== $user->band_id) {
            return response()->json(['message' => 'No tienes permiso para eliminar esta canción.'], 403);
        }

        $repertoire->delete();

        return response()->json(['message' => 'Canción eliminada correctamente.']);
    }
}
