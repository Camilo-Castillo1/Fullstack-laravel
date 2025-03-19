<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PoliticaInventario;

class PoliticaInventarioController extends Controller
{
    /**
     * 📌 Listar todas las políticas de inventario.
     */
    public function index()
    {
        return response()->json(PoliticaInventario::all(), 200);
    }

    /**
     * 📌 Crear una nueva política de inventario.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:politicas_inventario',
            'tipo' => 'required|in:PEPS,UEPS,FIFO',
            'aplicable_a' => 'required|in:refrigerado,seco,congelado',
            'fecha_implementacion' => 'required|date',
            'ubicacion_id' => 'required|exists:ubicaciones_almacenamiento,id',
            'categoria_id' => 'nullable|exists:categorias,id',
            'almacen_id' => 'nullable|exists:almacenes,id'
        ]);

        $politica = PoliticaInventario::create($request->all());

        return response()->json($politica, 201);
    }

    /**
     * 📌 Obtener una política de inventario por ID.
     */
    public function show($id)
    {
        $politica = PoliticaInventario::find($id);

        if (!$politica) {
            return response()->json(['error' => 'Política de inventario no encontrada'], 404);
        }

        return response()->json($politica);
    }

    /**
     * 📌 Actualizar una política de inventario existente.
     */
    public function update(Request $request, $id)
    {
        $politica = PoliticaInventario::find($id);

        if (!$politica) {
            return response()->json(['error' => 'Política de inventario no encontrada'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|string|max:50|unique:politicas_inventario,nombre,' . $id,
            'tipo' => 'sometimes|in:PEPS,UEPS,FIFO',
            'aplicable_a' => 'sometimes|in:refrigerado,seco,congelado',
            'fecha_implementacion' => 'sometimes|date',
            'ubicacion_id' => 'sometimes|exists:ubicaciones_almacenamiento,id',
            'categoria_id' => 'nullable|exists:categorias,id',
            'almacen_id' => 'nullable|exists:almacenes,id'
        ]);

        $politica->update($request->all());

        return response()->json($politica);
    }

    /**
     * 📌 Eliminar una política de inventario.
     */
    public function destroy($id)
    {
        $politica = PoliticaInventario::find($id);

        if (!$politica) {
            return response()->json(['error' => 'Política de inventario no encontrada'], 404);
        }

        $politica->delete();

        return response()->json(['message' => 'Política de inventario eliminada correctamente']);
    }
}
