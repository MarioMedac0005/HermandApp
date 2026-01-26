<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        /* 
            Este metodo sendResetLink, es un metodo oficial de Laravel,
            envia el correo con el token para poder resetear la contraseña.
        */
        $status = Password::sendResetLink($request->only('email'));

        /* 
            El metodo retorna un estado, segun si salio bien o mal, en
            este caso comprobamos ese estado.
         */
        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'status' => true,
                'message' => __($status)
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => __($status)
            ], 400);
        }

    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        /* 
            Esta parte del codigo, esta sacada de la documentacion oficial
            de Laravel. Simplemente se encarga de cambiar la contraseña, a
            la nueva contraseña que se ha enviado.

            Source: https://laravel.com/docs/12.x/passwords#main-content
        */
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'status' => true,
                'message' => 'La contraseña ha sido reseteada correctamente',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => __($status),
            ], 422);
        }
    }
}
