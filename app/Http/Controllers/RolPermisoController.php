<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol;
use App\Models\Permiso;
use App\Models\RolPermiso;

class RolPermisoController extends Controller
{
    /**
     * 📌 Listar todos los permisos asignados a roles.
     */
    public function index()
    {
        return response()->json(RolPermiso::all(), 200);
    }

    /**
     * 📌 Asignar un permiso a un rol.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_rol' => 'required|exists:roles,id',
            'id_permiso' => 'required|exists:permisos,id',
            'asignado_por' => 'nullable|exists:usuarios,id'
        ]);

        // Verificar si ya existe la relación para evitar duplicados
        $rolPermiso = RolPermiso::firstOrCreate([
            'id_rol' => $request->id_rol,
            'id_permiso' => $request->id_permiso
        ], [
            'asignado_por' => $request->asignado_por
        ]);

        return response()->json($rolPermiso, 201);
    }

    /**
     * 📌 Obtener los permisos asignados a un rol específico.
     */
    public function show($id)
    {
        $rol = Rol::find($id);

        if (!$rol) {
            return response()->json(['error' => 'Rol no encontrado'], 404);
        }

        return response()->json($rol->permisos);
    }

    /**
     * 📌 No se recomienda actualizar permisos de roles manualmente, se deben gestionar con `store` o `destroy`.
     */
    public function update(Request $request, $id)
    {
        return response()->json(['error' => 'No se permite actualizar registros de permisos de roles'], 403);
    }

    /**
     * 📌 Eliminar un permiso asignado a un rol.
     */
    public function destroy($id)
    {
        $rolPermiso = RolPermiso::find($id);

        if (!$rolPermiso) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $rolPermiso->delete();

        return response()->json(['message' => 'Permiso eliminado del rol correctamente']);
    }
}
