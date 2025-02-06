<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    /**
     * Obtener todos los comentarios.
     */
    public function index()
    {
        return response()->json(Comentario::with(['usuario', 'noticia'])->get(), 200);
    }

    /**
     * Obtener un comentario específico por ID.
     */
    public function show($id)
    {
        $comentario = Comentario::with(['usuario', 'noticia'])->find($id);
        
        if (!$comentario) {
            return response()->json(['message' => 'Comentario no encontrado'], 404);
        }

        return response()->json($comentario, 200);
    }

    /**
     * Crear un nuevo comentario.
     */
    public function store(Request $request)
    {
        $request->validate([
            'contenido' => 'required|string',
            'usuario_id' => 'required|exists:usuarios,id',
            'noticia_id' => 'required|exists:noticias,id',
            'fecha' => 'required|date'
        ]);

        $comentario = Comentario::create($request->all());

        return response()->json($comentario, 201);
    }

    /**
     * Actualizar un comentario existente.
     */
    public function update(Request $request, $id)
    {
        $comentario = Comentario::find($id);
        
        if (!$comentario) {
            return response()->json(['message' => 'Comentario no encontrado'], 404);
        }

        $request->validate([
            'contenido' => 'sometimes|string',
            'usuario_id' => 'sometimes|exists:usuarios,id',
            'noticia_id' => 'sometimes|exists:noticias,id',
            'fecha' => 'sometimes|date'
        ]);

        $comentario->update($request->all());

        return response()->json($comentario, 200);
    }

    /**
     * Eliminar un comentario.
     */
    public function destroy($id)
    {
        $comentario = Comentario::find($id);
        
        if (!$comentario) {
            return response()->json(['message' => 'Comentario no encontrado'], 404);
        }

        $comentario->delete();

        return response()->json(['message' => 'Comentario eliminado'], 200);
    }
}
