<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Band;
use App\Models\Brotherhood;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        try {
            $results = collect();
            $countries = ['Almeria', 'Cadiz', 'Cordoba', 'Granada', 'Huelva', 'Jaen', 'Malaga', 'Sevilla'];

            $searchTerm = $request->input('resultado', '');
            $province = $request->has('provincia') ? ucfirst(strtolower($request->provincia)) : null;
            $filter = $province && in_array($province, $countries);

            $searchType = [
                'band' => Band::class,
                'hermandad' => Brotherhood::class
            ];

            $type = $request->input('tipo');

            if ($type && array_key_exists($type, $searchType)) {
                $model = $searchType[$type];
                $results = $this->search($model, $searchTerm, $filter, $province);
            } else {
                $brotherhoods = $this->search(Brotherhood::class, $searchTerm, $filter, $province);
                $bands = $this->search(Band::class, $searchTerm, $filter, $province);

                $results = $results->merge($brotherhoods)->merge($bands);
            }

            return $this->successResponse($results, 'Se han obtenido correctamente los resultados de la busqueda');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Ha ocurrido un error al obtener los resultados de la busqueda');
        }
    }

    /**
     * Realiza la búsqueda en el modelo correspondiente (Band o Brotherhood).
     *
     * @param string $model El modelo a utilizar para la búsqueda (Band o Brotherhood).
     * @param string $search El término de búsqueda.
     * @param bool $filter Si se debe aplicar el filtro de provincia.
     * @param string|null $province Provincia a filtrar (opcional).
     * @return \Illuminate\Support\Collection Los resultados de la búsqueda.
     */
    private function search(string $model, string $search, bool $filter, ?string $province)
    {
        $query = $model::where('name', 'like', "%{$search}%");

        if ($filter) {
            $query = $query->where('country', $province);
        }

        return $query->get();
    }
}
