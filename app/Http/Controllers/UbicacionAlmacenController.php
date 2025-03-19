<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UbicacionAlmacen;

class UbicacionAlmacenController extends Controller
{
    /**
     * 📌 Listar todas las ubicaciones de almacenes.
     */
    public function index()
    {
        return response()->json(UbicacionAlmacen::all(), 200);
    }

    /**
     * 📌 Crear una nueva ubicación en un almacén.
     */
    public function store(Request $request)
    {
        $request->validate([
            'almacen_id' => 'required|exists:almacenes,id',
            'codigo_ubicacion' => 'required|string|max:50|unique:ubicaciones_almacenamiento',
            'tipo_almacenamiento' => 'required|in:refrigerado,congelado,seco',
            'capacidad_maxima' => 'required|integer|min:1',
            'restricciones' => 'nullable|string'
        ]);

        $ubicacion = UbicacionAlmacen::create($request->all());

        return response()->json($ubicacion, 201);
    }

    /**
     * 📌 Obtener una ubicación específica por ID.
     */
    public function show($id)
    {
        $ubicacion = UbicacionAlmacen::find($id);

        if (!$ubicacion) {
            return response()->json(['error' => 'Ubicación no encontrada'], 404);
        }

        return response()->json($ubicacion);
    }

    /**
     * 📌 Actualizar una ubicación de almacén existente.
     */
    public function update(Request $request, $id)
    {
        $ubicacion = UbicacionAlmacen::find($id);

        if (!$ubicacion) {
            return response()->json(['error' => 'Ubicación no encontrada'], 404);
        }

        $request->validate([
            'almacen_id' => 'sometimes|exists:almacenes,id',
            'codigo_ubicacion' => 'sometimes|string|max:50|unique:ubicaciones_almacenamiento,codigo_ubicacion,' . $id,
            'tipo_almacenamiento' => 'sometimes|in:refrigerado,congelado,seco',
            'capacidad_maxima' => 'sometimes|integer|min:1',
            'restricciones' => 'sometimes|string'
        ]);

        $ubicacion->update($request->all());

        return response()->json($ubicacion);
    }

    /**
     * 📌 Eliminar una ubicación de almacén.
     */
    public function destroy($id)
    {
        $ubicacion = UbicacionAlmacen::find($id);

        if (!$ubicacion) {
            return response()->json(['error' => 'Ubicación no encontrada'], 404);
        }

        $ubicacion->delete();

        return response()->json(['message' => 'Ubicación eliminada correctamente']);
    }
}
