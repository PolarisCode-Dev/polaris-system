<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    //Función para manejar el login de usuarios
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials.'], 401);
        }

        return response()->json([
            'token' => $token,
            'type' => 'bearer'
        ]);
    }

    //Función para obtener los datos del usuario autenticado
    public function me()
    {
        $user = auth('api')->user()->load('company');

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'company' => $user->company ? [
                'id' => $user->company->id,
                'name' => $user->company->name,
                'email' => $user->company->email,
            ] : null
        ]);
    }

    //Función para manejar el logout de usuarios
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Logout successful.']);
    }
}
