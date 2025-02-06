<?php

namespace App\Http\Controllers;

use App\Models\Suscripcion;
use Illuminate\Http\Request;

class SuscripcionController extends Controller
{
    /**
     * Obtener todas las suscripciones.
     */
    public function index()
    {
        return response()->json(Suscripcion::with(['usuario', 'plan'])->get(), 200);
    }

    /**
     * Obtener una suscripción específica por ID.
     */
    public function show($id)
    {
        $suscripcion = Suscripcion::with(['usuario', 'plan'])->find($id);
        
        if (!$suscripcion) {
            return response()->json(['message' => 'Suscripción no encontrada'], 404);
        }

        return response()->json($suscripcion, 200);
    }

    /**
     * Crear una nueva suscripción.
     */
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'plan_id' => 'required|exists:planes,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'estado' => 'required|string|max:50'
        ]);

        $suscripcion = Suscripcion::create($request->all());

        return response()->json($suscripcion, 201);
    }

    /**
     * Actualizar una suscripción existente.
     */
    public function update(Request $request, $id)
    {
        $suscripcion = Suscripcion::find($id);
        
        if (!$suscripcion) {
            return response()->json(['message' => 'Suscripción no encontrada'], 404);
        }

        $request->validate([
            'usuario_id' => 'sometimes|exists:usuarios,id',
            'plan_id' => 'sometimes|exists:planes,id',
            'fecha_inicio' => 'sometimes|date',
            'fecha_fin' => 'sometimes|date|after:fecha_inicio',
            'estado' => 'sometimes|string|max:50'
        ]);

        $suscripcion->update($request->all());

        return response()->json($suscripcion, 200);
    }

    /**
     * Eliminar una suscripción.
     */
    public function destroy($id)
    {
        $suscripcion = Suscripcion::find($id);
        
        if (!$suscripcion) {
            return response()->json(['message' => 'Suscripción no encontrada'], 404);
        }

        $suscripcion->delete();

        return response()->json(['message' => 'Suscripción eliminada'], 200);
    }
}
