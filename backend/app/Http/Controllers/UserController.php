<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('company')->get();

        return response()->json([
            'status' => 200,
            'message' => 'Users retrieved successfully.',
            'data' => UserResource::collection($users),
        ], 200);
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
            'status' => 201,
            'message' => 'User created successfully.',
            'data' => new UserResource($user->load('company')),
        ], 201);
    }


    public function show($id)
    {
        $user = User::with('company')->findOrFail($id);

        return response()->json([
            'status' => 200,
            'message' => 'User retrieved successfully.',
            'data' => new UserResource($user),
        ], 200);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validated();

        if (! $request->filled('password')) {
            unset($validated['password']);
        }

        $user->fill($validated);

        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'User updated successfully.',
            'data' => new UserResource($user->load('company')),
        ], 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json([
            'status' => 200,
            'message' => 'User deleted successfully.',
            'data' => null,
        ], 200);
    }
}

