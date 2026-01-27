<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class GestorController extends Controller
{
    public function index()
    {
        try {
            $gestores = User::whereHas('roles', function ($query) {
                $query->where('name', 'gestor');
            })->with(['band', 'brotherhood', 'roles'])->paginate(10);

            return UserResource::collection($gestores)
                ->additional([
                    'success' => true,
                    'message' => 'Listado de gestores obtenido correctamente',
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Exception $e) {
            return $this->errorResponse('Ha ocurrido un error al obtener el listado de gestores', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'band_id' => 'nullable|exists:bands,id|required_without:brotherhood_id',
            'brotherhood_id' => 'nullable|exists:hermandades,id|required_without:band_id',
        ]);

        if ($request->filled('band_id') && $request->filled('brotherhood_id')) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede crear un gestor con bandas y hermandades',
            ], 400);
        }

        $gestor = null;

        DB::transaction(function () use ($request, &$gestor) {
            $gestor = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt(Str::random(16)),
                'band_id' => $request->band_id,
                'brotherhood_id' => $request->brotherhood_id,
            ]);

            $gestor->assignRole('gestor');
        });

        $mailSent = true;

        try {
            $status = Password::broker()->sendResetLink(
                $request->only('email')
            );

            if ($status !== Password::RESET_LINK_SENT) {
                $mailSent = false;
            }
        } catch (\Throwable $e) {
            $mailSent = false;

            Log::error('Error enviando email de reset', [
                'email' => $request->email,
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'mail_sent' => $mailSent,
            'message' => $mailSent
                ? 'Gestor creado y email enviado'
                : 'Gestor creado, pero el email NO pudo enviarse',
        ], 201);
    }

    public function destroy(User $gestor)
    {
        try {
            if (! $gestor->hasRole('gestor')) {
                return response()->json([
                    'success' => false,
                    'message' => 'El usuario que estas intentado eliminar no es un gestor'
                ], 404);
            }

            DB::transaction(function () use ($gestor) {
                $gestor->removeRole('gestor');
                $gestor->delete();
            });

            return response()->json([
                'success' => true,
                'message' => 'Gestor eliminado correctamente'
            ], 200);

        } catch (\Exception $e) {
            return $this->errorResponse(
                'Ha ocurrido un error al eliminar el gestor',
                $e->getMessage()
            );
        }
    }
}
