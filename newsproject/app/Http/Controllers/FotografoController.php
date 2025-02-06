<?php

namespace App\Http\Controllers;

use App\Models\Fotografo;
use Illuminate\Http\Request;

class FotografoController extends Controller
{
    /**
     * Obtener todos los fotógrafos.
     */
    public function index()
    {
        return response()->json(Fotografo::all(), 200);
    }

    /**
     * Obtener un fotógrafo específico por ID.
     */
    public function show($id)
    {
        $fotografo = Fotografo::find($id);
        
        if (!$fotografo) {
            return response()->json(['message' => 'Fotógrafo no encontrado'], 404);
        }

        return response()->json($fotografo, 200);
    }

    /**
     * Crear un nuevo fotógrafo.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|unique:fotografos,email',
            'telefono' => 'nullable|string|max:15',
            'especialidad' => 'nullable|string|max:255'
        ]);

        $fotografo = Fotografo::create($request->all());

        return response()->json($fotografo, 201);
    }

    /**
     * Actualizar un fotógrafo existente.
     */
    public function update(Request $request, $id)
    {
        $fotografo = Fotografo::find($id);
        
        if (!$fotografo) {
            return response()->json(['message' => 'Fotógrafo no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|unique:fotografos,email,' . $id,
            'telefono' => 'nullable|string|max:15',
            'especialidad' => 'nullable|string|max:255'
        ]);

        $fotografo->update($request->all());

        return response()->json($fotografo, 200);
    }

    /**
     * Eliminar un fotógrafo.
     */
    public function destroy($id)
    {
        $fotografo = Fotografo::find($id);
        
        if (!$fotografo) {
            return response()->json(['message' => 'Fotógrafo no encontrado'], 404);
        }

        $fotografo->delete();

        return response()->json(['message' => 'Fotógrafo eliminado'], 200);
    }
}
