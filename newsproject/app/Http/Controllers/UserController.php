<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Obtener todos los usuarios.
     */
    public function index()
    {
        try {
            $data = User::all();
            return response()->json([
                'success' => true,
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error obteniendo usuarios: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener un usuario específico por ID.
     */
    public function show($id)
    {
        try {
            $user = User::find($id);
            
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Usuario no encontrado'], 404);
            }
    
            return response()->json([
                'success' => true,
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error obteniendo usuario: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear un nuevo usuario.
     */
    public function store(Request $request)
    {
        try {
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
    
            return response()->json([
                'success' => true,
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creando usuario: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un usuario existente.
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
            
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Usuario no encontrado'], 404);
            }
    
            $request->validate([
                'nombre' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|email|unique:usuarios,email,' . $id,
                'password' => 'sometimes|string|min:6',
                'rol' => 'sometimes|string'
            ]);
    
            if ($request->has('password')) {
                $request->merge(['password' => Hash::make($request->password)]);
            }

            if (!$user->isDirty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se realizaron cambios en el usuario'
                ], 400);
            }
    
            $user->update($request->all());
    
            return response()->json([
                'success' => true,
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error actualizando usuario: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un usuario.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
    
            $user->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Usuario eliminado correctamente'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error eliminando usuario: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado o error en la operación',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
