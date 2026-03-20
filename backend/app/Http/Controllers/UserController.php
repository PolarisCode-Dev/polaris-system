<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        //logica
    }

    public function store(Request $request)
    {
        //logica
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
