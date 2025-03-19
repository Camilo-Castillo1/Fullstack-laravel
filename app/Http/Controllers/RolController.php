<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol;

class RolController extends Controller
{
    /**
     * 📌 Listar todos los roles.
     */
    public function index()
    {
        return response()->json(Rol::all(), 200);
    }

    /**
     * 📌 Crear un nuevo rol.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:roles',
            'descripcion' => 'nullable|string'
        ]);

        $rol = Rol::create($request->all());

        return response()->json($rol, 201);
    }

    /**
     * 📌 Obtener un rol por ID.
     */
    public function show($id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return response()->json(['error' => 'Rol no encontrado'], 404);
        }

        return response()->json($rol);
    }

    /**
     * 📌 Actualizar un rol existente.
     */
    public function update(Request $request, $id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return response()->json(['error' => 'Rol no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|string|max:100|unique:roles,nombre,' . $id,
            'descripcion' => 'sometimes|string'
        ]);

        $rol->update($request->all());

        return response()->json($rol);
    }

    /**
     * 📌 Eliminar un rol.
     */
    public function destroy($id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return response()->json(['error' => 'Rol no encontrado'], 404);
        }

        $rol->delete();

        return response()->json(['message' => 'Rol eliminado correctamente']);
    }
}
