<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Obtener todas las categorías.
     */
    public function index()
    {
        return response()->json(Categoria::all(), 200);
    }

    /**
     * Obtener una categoría específica por ID.
     */
    public function show($id)
    {
        $categoria = Categoria::find($id);
        
        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        return response()->json($categoria, 200);
    }

    /**
     * Crear una nueva categoría.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string'
        ]);

        $categoria = Categoria::create($request->all());

        return response()->json($categoria, 201);
    }

    /**
     * Actualizar una categoría existente.
     */
    public function update(Request $request, $id)
    {
        $categoria = Categoria::find($id);
        
        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'descripcion' => 'nullable|string'
        ]);

        $categoria->update($request->all());

        return response()->json($categoria, 200);
    }

    /**
     * Eliminar una categoría.
     */
    public function destroy($id)
    {
        $categoria = Categoria::find($id);
        
        if (!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'], 404);
        }

        $categoria->delete();

        return response()->json(['message' => 'Categoría eliminada'], 200);
    }
}
