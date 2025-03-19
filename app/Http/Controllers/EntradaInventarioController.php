<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EntradaInventario;

class EntradaInventarioController extends Controller
{
    /**
     * 📌 Listar todas las entradas de inventario.
     */
    public function index()
    {
        return response()->json(EntradaInventario::all(), 200);
    }

    /**
     * 📌 Crear una nueva entrada de inventario.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'usuario_id' => 'required|exists:usuarios,id',
            'cantidad' => 'required|integer|min:1',
            'motivo' => 'nullable|string'
        ]);

        $entrada = EntradaInventario::create([
            'lote_id' => $request->lote_id,
            'usuario_id' => $request->usuario_id,
            'cantidad' => $request->cantidad,
            'motivo' => $request->motivo,
            'fecha_movimiento' => now() // Se establece automáticamente
        ]);

        return response()->json($entrada, 201);
    }

    /**
     * 📌 Obtener una entrada de inventario por ID.
     */
    public function show($id)
    {
        $entrada = EntradaInventario::find($id);

        if (!$entrada) {
            return response()->json(['error' => 'Entrada de inventario no encontrada'], 404);
        }

        return response()->json($entrada);
    }

    /**
     * 📌 Actualizar una entrada de inventario existente.
     */
    public function update(Request $request, $id)
    {
        $entrada = EntradaInventario::find($id);

        if (!$entrada) {
            return response()->json(['error' => 'Entrada de inventario no encontrada'], 404);
        }

        $request->validate([
            'lote_id' => 'sometimes|exists:lotes,id',
            'usuario_id' => 'sometimes|exists:usuarios,id',
            'cantidad' => 'sometimes|integer|min:1',
            'motivo' => 'sometimes|string'
        ]);

        $entrada->update($request->all());

        return response()->json($entrada);
    }

    /**
     * 📌 Eliminar una entrada de inventario.
     */
    public function destroy($id)
    {
        $entrada = EntradaInventario::find($id);

        if (!$entrada) {
            return response()->json(['error' => 'Entrada de inventario no encontrada'], 404);
        }

        $entrada->delete();

        return response()->json(['message' => 'Entrada de inventario eliminada correctamente']);
    }
}
