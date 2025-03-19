<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permiso;

class PermisoController extends Controller
{
    /**
     * 📌 Listar todos los permisos.
     */
    public function index()
    {
        return response()->json(Permiso::all(), 200);
    }

    /**
     * 📌 Crear un nuevo permiso.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:permisos',
            'modulo' => 'required|string|max:50',
            'descripcion' => 'nullable|string'
        ]);

        $permiso = Permiso::create($request->all());

        return response()->json($permiso, 201);
    }

    /**
     * 📌 Obtener un permiso por ID.
     */
    public function show($id)
    {
        $permiso = Permiso::find($id);

        if (!$permiso) {
            return response()->json(['error' => 'Permiso no encontrado'], 404);
        }

        return response()->json($permiso);
    }

    /**
     * 📌 Actualizar un permiso existente.
     */
    public function update(Request $request, $id)
    {
        $permiso = Permiso::find($id);

        if (!$permiso) {
            return response()->json(['error' => 'Permiso no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|string|max:100|unique:permisos,nombre,' . $id,
            'modulo' => 'sometimes|string|max:50',
            'descripcion' => 'sometimes|string'
        ]);

        $permiso->update($request->all());

        return response()->json($permiso);
    }

    /**
     * 📌 Eliminar un permiso.
     */
    public function destroy($id)
    {
        $permiso = Permiso::find($id);

        if (!$permiso) {
            return response()->json(['error' => 'Permiso no encontrado'], 404);
        }

        $permiso->delete();

        return response()->json(['message' => 'Permiso eliminado correctamente']);
    }
}
