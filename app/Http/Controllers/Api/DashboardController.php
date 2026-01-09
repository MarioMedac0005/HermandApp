<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\Band;
use App\Models\Brotherhood;
use App\Models\Contract;
use App\Models\Procession;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function count()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => [
                    'availabilities' => Availability::count(),
                    'bands' => Band::count(),
                    'brotherhoods' => Brotherhood::count(),
                    'contracts' => Contract::count(),
                    'processions' => Procession::count(),
                    'users' => User::count(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al obtener las cantidades de los registros',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
