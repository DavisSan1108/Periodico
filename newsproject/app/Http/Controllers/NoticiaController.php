<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    /**
     * Obtener todas las noticias.
     */
    public function index()
    {
        return response()->json(Noticia::with(['autor', 'categoria'])->get(), 200);
    }

    /**
     * Obtener una noticia específica por ID.
     */
    public function show($id)
    {
        $noticia = Noticia::with(['autor', 'categoria'])->find($id);
        
        if (!$noticia) {
            return response()->json(['message' => 'Noticia no encontrada'], 404);
        }

        return response()->json($noticia, 200);
    }

    /**
     * Crear una nueva noticia.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'autor_id' => 'required|exists:redactores,id',
            'categoria_id' => 'required|exists:categorias,id',
            'fecha_publicacion' => 'required|date'
        ]);

        $noticia = Noticia::create($request->all());

        return response()->json($noticia, 201);
    }

    /**
     * Actualizar una noticia existente.
     */
    public function update(Request $request, $id)
    {
        $noticia = Noticia::find($id);
        
        if (!$noticia) {
            return response()->json(['message' => 'Noticia no encontrada'], 404);
        }

        $request->validate([
            'titulo' => 'sometimes|string|max:255',
            'contenido' => 'sometimes|string',
            'autor_id' => 'sometimes|exists:redactores,id',
            'categoria_id' => 'sometimes|exists:categorias,id',
            'fecha_publicacion' => 'sometimes|date'
        ]);

        $noticia->update($request->all());

        return response()->json($noticia, 200);
    }

    /**
     * Eliminar una noticia.
     */
    public function destroy($id)
    {
        $noticia = Noticia::find($id);
        
        if (!$noticia) {
            return response()->json(['message' => 'Noticia no encontrada'], 404);
        }

        $noticia->delete();

        return response()->json(['message' => 'Noticia eliminada'], 200);
    }
}
