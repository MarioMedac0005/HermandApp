<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = User::with(['band', 'brotherhood'])->paginate(10);

            return UserResource::collection($user)
                ->additional([
                    'success' => true,
                    'message' => 'Listado de usuarios paginadas obtenido correctamente'
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return $this->errorResponse('Ha ocurrido un error al obtener el listado de usuarios', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $user = User::create($request->validated());

            return (new UserResource($user))
                ->additional([
                    'success' => true,
                    'message' => 'El usuario ha sido creado correctamente'
                ])
                ->response()
                ->setStatusCode(201);
        } catch (\Exception $e) {
            return $this->errorResponse('Ha ocurrido un error al intentar crear un usuario', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        try {
            return (new UserResource($user))
                ->additional([
                    'success' => true,
                    'message' => 'El usuario ha sido obtenido correctamente',
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return $this->errorResponse('Ha ocurrido un error al intentar mostrar un usuario', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $user->update($request->validated());

            return (new UserResource($user))
                ->additional([
                    'success' => true,
                    'message' => 'El usuario ha sido actualizado correctamente',
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return $this->errorResponse('Ha ocurrido un error al intentar actualizar un usuario', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {

            if (Auth::id() === $user->id && Auth::user()->hasRole('admin')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Un administrador no puede eliminarse a sí mismo',
                ], 403);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'El usuario ha sido eliminado correctamente',
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Ha ocurrido un error al intentar borrar un usuario',
                $e->getMessage()
            );
        }
    }
}
