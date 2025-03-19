<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalidaInventario;

class SalidaInventarioController extends Controller
{
    /**
     * 📌 Listar todas las salidas de inventario.
     */
    public function index()
    {
        return response()->json(SalidaInventario::all(), 200);
    }

    /**
     * 📌 Registrar una nueva salida de inventario.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'usuario_id' => 'required|exists:usuarios,id',
            'cantidad' => 'required|integer|min:1',
            'motivo' => 'nullable|string'
        ]);

        $salida = SalidaInventario::create([
            'lote_id' => $request->lote_id,
            'usuario_id' => $request->usuario_id,
            'cantidad' => $request->cantidad,
            'motivo' => $request->motivo,
            'fecha_movimiento' => now() // Se establece automáticamente
        ]);

        return response()->json($salida, 201);
    }

    /**
     * 📌 Obtener una salida de inventario por ID.
     */
    public function show($id)
    {
        $salida = SalidaInventario::find($id);

        if (!$salida) {
            return response()->json(['error' => 'Salida de inventario no encontrada'], 404);
        }

        return response()->json($salida);
    }

    /**
     * 📌 Actualizar una salida de inventario existente.
     */
    public function update(Request $request, $id)
    {
        $salida = SalidaInventario::find($id);

        if (!$salida) {
            return response()->json(['error' => 'Salida de inventario no encontrada'], 404);
        }

        $request->validate([
            'lote_id' => 'sometimes|exists:lotes,id',
            'usuario_id' => 'sometimes|exists:usuarios,id',
            'cantidad' => 'sometimes|integer|min:1',
            'motivo' => 'sometimes|string'
        ]);

        $salida->update($request->all());

        return response()->json($salida);
    }

    /**
     * 📌 Eliminar una salida de inventario.
     */
    public function destroy($id)
    {
        $salida = SalidaInventario::find($id);

        if (!$salida) {
            return response()->json(['error' => 'Salida de inventario no encontrada'], 404);
        }

        $salida->delete();

        return response()->json(['message' => 'Salida de inventario eliminada correctamente']);
    }
}
