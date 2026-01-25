<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Band;
use App\Models\Brotherhood;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        try {
            $q = $request->input('q');
            $city = $request->input('city');
            $type = $request->input('type');
            $perPage = 1;

            $results = collect();

            if (!$type || $type === 'band') {
                $bands = Band::query()
                    ->when($q, function ($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%");
                    })
                    ->when($city, function ($query) use ($city) {
                        $query->where('city', $city);
                    })
                    ->get()
                    ->map(function ($band) {
                        return [
                            'id' => $band->id,
                            'name' => $band->name,
                            'description' => $band->description,
                            'city' => $band->city,
                            'email' => $band->email,
                            'type' => 'band',
                            'created_at' => $band->created_at,
                        ];
                    });

                $results = $results->merge($bands);
            }

            if (!$type || $type === 'hermandad') {
                $brotherhoods = Brotherhood::query()
                    ->when($q, function ($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%");
                    })
                    ->when($city, function ($query) use ($city) {
                        $query->where('city', $city);
                    })
                    ->get()
                    ->map(function ($h) {
                        return [
                            'id' => $h->id,
                            'name' => $h->name,
                            'description' => $h->description,
                            'city' => $h->city,
                            'email' => $h->email,
                            'type' => 'brotherhood',
                            'created_at' => $h->created_at,
                        ];
                    });

                $results = $results->merge($brotherhoods);
            }
            $results = $results->sortByDesc('created_at')->values();

            $page = LengthAwarePaginator::resolveCurrentPage();

            $paginated = new LengthAwarePaginator(
                $results->forPage($page, $perPage)->values(),
                $results->count(),
                $perPage,
                $page,
                [
                    'path' => url()->current(),
                    'query' => $request->query(),
                ]
            );

            return $this->successResponse(
                $paginated,
                'Se han obtenido correctamente los resultados de la búsqueda'
            );
        } catch (\Throwable $e) {
            return $this->errorResponse(
                $e->getMessage(),
                'Ha ocurrido un error al obtener los resultados de la búsqueda'
            );
        }
    }
}
