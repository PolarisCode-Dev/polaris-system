<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        //logica
    }

    public function store(Request $request)
    {
        // Validación básica
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'company_id' => 'required'
        ]);

        // Crear usuario con password hasheado
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company_id' => $request->company_id,
        ]);

        return response()->json([
            'message' => 'Usuario creado correctamente',
            'user' => $user
        ], 201);
    }


    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Usuario no encontrado.',
                'data' => null,
            ], 404);
        }

        $user->load('company');

        return response()->json([
            'message' => 'Usuario obtenido exitosamente.',
            'data' => new UserResource($user),
        ]);
    }

    public function update(Request $request, $id)
    {
        //logica
    }

    public function destroy($id)
    {
        //logica
    }
}
