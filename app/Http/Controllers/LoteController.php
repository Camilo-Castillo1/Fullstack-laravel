<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lote;

class LoteController extends Controller
{
    /**
     * 📌 Listar todos los lotes.
     */
    public function index()
    {
        return response()->json(Lote::all(), 200);
    }

    /**
     * 📌 Crear un nuevo lote.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo_lote' => 'required|string|max:50|unique:lotes',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'fecha_ingreso' => 'required|date',
            'fecha_vencimiento' => 'nullable|date|after_or_equal:fecha_ingreso',
            'estado' => 'required|in:disponible,agotado,vencido'
        ]);

        $lote = Lote::create([
            'codigo_lote' => $request->codigo_lote,
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'fecha_ingreso' => $request->fecha_ingreso,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'estado' => $request->estado
        ]);

        return response()->json($lote, 201);
    }

    /**
     * 📌 Obtener un lote por ID.
     */
    public function show($id)
    {
        $lote = Lote::find($id);

        if (!$lote) {
            return response()->json(['error' => 'Lote no encontrado'], 404);
        }

        return response()->json($lote);
    }

    /**
     * 📌 Actualizar un lote existente.
     */
    public function update(Request $request, $id)
    {
        $lote = Lote::find($id);

        if (!$lote) {
            return response()->json(['error' => 'Lote no encontrado'], 404);
        }

        $request->validate([
            'codigo_lote' => 'sometimes|string|max:50|unique:lotes,codigo_lote,' . $id,
            'producto_id' => 'sometimes|exists:productos,id',
            'cantidad' => 'sometimes|integer|min:1',
            'fecha_ingreso' => 'sometimes|date',
            'fecha_vencimiento' => 'sometimes|date|after_or_equal:fecha_ingreso',
            'estado' => 'sometimes|in:disponible,agotado,vencido'
        ]);

        $lote->update($request->all());

        return response()->json($lote);
    }

    /**
     * 📌 Eliminar un lote.
     */
    public function destroy($id)
    {
        $lote = Lote::find($id);

        if (!$lote) {
            return response()->json(['error' => 'Lote no encontrado'], 404);
        }

        $lote->delete();

        return response()->json(['message' => 'Lote eliminado correctamente']);
    }
}
