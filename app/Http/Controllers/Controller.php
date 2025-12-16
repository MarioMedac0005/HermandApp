<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    /**
     * Devuelve una respuesta JSON con éxito
     * 
     * @param mixed $data Los datos que va a incluir la respuesta
     * @param string $message Mensaje descriptivo de la operacion
     * @return \Illuminate\Http\JsonResponse Respuesta JSON con éxito y datos
     */
    protected function successResponse($data, string $message): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], 200);
    }

    /**
     * Devuelve una respuesta JSON de error
     * 
     * @param string $error Mensaje descriptivo del error
     * @param string $message Mensaje de error general
     * @return \Illuminate\Http\JsonResponse Respuesta JSON de error
     */
    protected function errorResponse(string $error, string $message): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Ha ocurrido un error al obtener los resultados de la busqueda',
            'error' => $error
        ], 500);
    }
}
