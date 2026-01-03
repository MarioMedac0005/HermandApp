<?php

namespace App\Http\Controllers\Api;

use App\Models\Band;
use App\Models\Brotherhood;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\FeaturedResource;

class FeaturedController extends Controller
{
    public function index()
    {
        try {

            $profiles = Cache::remember('featured_profiles', 600, function () {

                $total = 4;

                $bandsCount = Band::count();
                $brotherhoodsCount = Brotherhood::count();

                $bandsToTake = min(rand(1, 3), $bandsCount);
                $brotherhoodsToTake = min($total - $bandsToTake, $brotherhoodsCount);

                $bands = Band::with('banner')
                    ->inRandomOrder()
                    ->take($bandsToTake)
                    ->get();

                $brotherhoods = Brotherhood::with('banner')
                    ->inRandomOrder()
                    ->take($brotherhoodsToTake)
                    ->get();

                return $bands
                    ->concat($brotherhoods)
                    ->shuffle();
            });

            return FeaturedResource::collection($profiles)
                ->additional([
                    'success' => true,
                    'message' => 'Perfiles destacados obtenidos correctamente',
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener perfiles destacados',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
