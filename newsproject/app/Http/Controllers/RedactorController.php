<?php

namespace App\Http\Controllers;

use App\Models\Redactor;
use Illuminate\Http\Request;

class RedactorController extends Controller
{
    /**
     * Obtener todos los redactores.
     */
    public function index()
    {
        return response()->json(Redactor::all(), 200);
    }

    /**
     * Obtener un redactor específico por ID.
     */
    public function show($id)
    {
        $redactor = Redactor::find($id);
        
        if (!$redactor) {
            return response()->json(['message' => 'Redactor no encontrado'], 404);
        }

        return response()->json($redactor, 200);
    }

    /**
     * Crear un nuevo redactor.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|unique:redactores,email',
            'telefono' => 'nullable|string|max:15'
        ]);

        $redactor = Redactor::create($request->all());

        return response()->json($redactor, 201);
    }

    /**
     * Actualizar un redactor existente.
     */
    public function update(Request $request, $id)
    {
        $redactor = Redactor::find($id);
        
        if (!$redactor) {
            return response()->json(['message' => 'Redactor no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|unique:redactores,email,' . $id,
            'telefono' => 'nullable|string|max:15'
        ]);

        $redactor->update($request->all());

        return response()->json($redactor, 200);
    }

    /**
     * Eliminar un redactor.
     */
    public function destroy($id)
    {
        $redactor = Redactor::find($id);
        
        if (!$redactor) {
            return response()->json(['message' => 'Redactor no encontrado'], 404);
        }

        $redactor->delete();

        return response()->json(['message' => 'Redactor eliminado'], 200);
    }
}
