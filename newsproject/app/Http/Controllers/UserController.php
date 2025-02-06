<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Obtener todos los usuarios.
     */
    public function index()
    {
        $data = User::all();
        return response()->json($data, 200);
    }

    /**
     * Obtener un usuario específico por ID.
     */
    public function show($id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user, 200);
    }

    /**
     * Crear un nuevo usuario.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|unique:usuarios,email',
            'password' => 'required|string|min:6',
            'rol' => 'required|string'
        ]);

        $user = User::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol
        ]);

        return response()->json($user, 201);
    }
}
