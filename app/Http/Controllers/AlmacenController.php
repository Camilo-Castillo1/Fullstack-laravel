<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;

class AlmacenController extends Controller
{
    /**
     * 📌 Listar todos los almacenes.
     */
    public function index()
    {
        return response()->json(Almacen::all(), 200);
    }

    /**
     * 📌 Crear un nuevo almacén.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:almacenes',
            'ubicacion' => 'required|string',
            'capacidad_maxima' => 'required|integer|min:1'
        ]);

        $almacen = Almacen::create($request->all());

        return response()->json($almacen, 201);
    }

    /**
     * 📌 Obtener un almacén por ID.
     */
    public function show($id)
    {
        $almacen = Almacen::find($id);

        if (!$almacen) {
            return response()->json(['error' => 'Almacén no encontrado'], 404);
        }

        return response()->json($almacen);
    }

    /**
     * 📌 Actualizar un almacén existente.
     */
    public function update(Request $request, $id)
    {
        $almacen = Almacen::find($id);

        if (!$almacen) {
            return response()->json(['error' => 'Almacén no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|string|max:255|unique:almacenes,nombre,' . $id,
            'ubicacion' => 'sometimes|string',
            'capacidad_maxima' => 'sometimes|integer|min:1'
        ]);

        $almacen->update($request->all());

        return response()->json($almacen);
    }

    /**
     * 📌 Eliminar un almacén.
     */
    public function destroy($id)
    {
        $almacen = Almacen::find($id);

        if (!$almacen) {
            return response()->json(['error' => 'Almacén no encontrado'], 404);
        }

        $almacen->delete();

        return response()->json(['message' => 'Almacén eliminado correctamente']);
    }
}
