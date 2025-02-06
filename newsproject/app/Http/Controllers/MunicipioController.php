<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{
    /**
     * Obtener todos los municipios.
     */
    public function index()
    {
        return response()->json(Municipio::all(), 200);
    }

    /**
     * Obtener un municipio específico por ID.
     */
    public function show($id)
    {
        $municipio = Municipio::find($id);
        
        if (!$municipio) {
            return response()->json(['message' => 'Municipio no encontrado'], 404);
        }

        return response()->json($municipio, 200);
    }

    /**
     * Crear un nuevo municipio.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'estado' => 'required|string|max:255'
        ]);

        $municipio = Municipio::create($request->all());

        return response()->json($municipio, 201);
    }

    /**
     * Actualizar un municipio existente.
     */
    public function update(Request $request, $id)
    {
        $municipio = Municipio::find($id);
        
        if (!$municipio) {
            return response()->json(['message' => 'Municipio no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'estado' => 'sometimes|string|max:255'
        ]);

        $municipio->update($request->all());

        return response()->json($municipio, 200);
    }

    /**
     * Eliminar un municipio.
     */
    public function destroy($id)
    {
        $municipio = Municipio::find($id);
        
        if (!$municipio) {
            return response()->json(['message' => 'Municipio no encontrado'], 404);
        }

        $municipio->delete();

        return response()->json(['message' => 'Municipio eliminado'], 200);
    }
}
