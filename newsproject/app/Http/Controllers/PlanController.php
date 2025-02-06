<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Obtener todos los planes.
     */
    public function index()
    {
        return response()->json(Plan::all(), 200);
    }

    /**
     * Obtener un plan específico por ID.
     */
    public function show($id)
    {
        $plan = Plan::find($id);
        
        if (!$plan) {
            return response()->json(['message' => 'Plan no encontrado'], 404);
        }

        return response()->json($plan, 200);
    }

    /**
     * Crear un nuevo plan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'duracion' => 'required|integer|min:1' // En días o meses
        ]);

        $plan = Plan::create($request->all());

        return response()->json($plan, 201);
    }

    /**
     * Actualizar un plan existente.
     */
    public function update(Request $request, $id)
    {
        $plan = Plan::find($id);
        
        if (!$plan) {
            return response()->json(['message' => 'Plan no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'sometimes|numeric|min:0',
            'duracion' => 'sometimes|integer|min:1'
        ]);

        $plan->update($request->all());

        return response()->json($plan, 200);
    }

    /**
     * Eliminar un plan.
     */
    public function destroy($id)
    {
        $plan = Plan::find($id);
        
        if (!$plan) {
            return response()->json(['message' => 'Plan no encontrado'], 404);
        }

        $plan->delete();

        return response()->json(['message' => 'Plan eliminado'], 200);
    }
}
