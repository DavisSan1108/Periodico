<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use Illuminate\Http\Request;

class ImagenController extends Controller
{
    /**
     * Obtener todas las imágenes.
     */
    public function index()
    {
        return response()->json(Imagen::with(['noticia'])->get(), 200);
    }

    /**
     * Obtener una imagen específica por ID.
     */
    public function show($id)
    {
        $imagen = Imagen::with(['noticia'])->find($id);
        
        if (!$imagen) {
            return response()->json(['message' => 'Imagen no encontrada'], 404);
        }

        return response()->json($imagen, 200);
    }

    /**
     * Crear una nueva imagen.
     */
    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|string|max:255',
            'noticia_id' => 'required|exists:noticias,id',
            'descripcion' => 'nullable|string'
        ]);

        $imagen = Imagen::create($request->all());

        return response()->json($imagen, 201);
    }

    /**
     * Actualizar una imagen existente.
     */
    public function update(Request $request, $id)
    {
        $imagen = Imagen::find($id);
        
        if (!$imagen) {
            return response()->json(['message' => 'Imagen no encontrada'], 404);
        }

        $request->validate([
            'url' => 'sometimes|string|max:255',
            'noticia_id' => 'sometimes|exists:noticias,id',
            'descripcion' => 'nullable|string'
        ]);

        $imagen->update($request->all());

        return response()->json($imagen, 200);
    }

    /**
     * Eliminar una imagen.
     */
    public function destroy($id)
    {
        $imagen = Imagen::find($id);
        
        if (!$imagen) {
            return response()->json(['message' => 'Imagen no encontrada'], 404);
        }

        $imagen->delete();

        return response()->json(['message' => 'Imagen eliminada'], 200);
    }
}
