<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol;
use App\Models\Permiso;
use App\Models\RolPermiso;

/**
* @OA\Info(
*     title="API de Asignación de Permisos a Roles",
*     version="1.0",
*     description="Gestión de relaciones entre roles y permisos"
* )
*
* @OA\Server(url="http://127.0.0.1:8000")
*/

/**
 * @OA\Schema(
 *     schema="RolPermiso",
 *     type="object",
 *     required={"id_rol", "id_permiso"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="id_rol", type="integer", example=2),
 *     @OA\Property(property="id_permiso", type="integer", example=5),
 *     @OA\Property(property="asignado_por", type="integer", nullable=true, example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class RolPermisoController extends Controller
{
    /**
     * Listar todos los permisos asignados a roles
     *
     * @OA\Get(
     *     path="/api/roles-permisos",
     *     tags={"RolPermiso"},
     *     summary="Listar todas las asignaciones de permisos a roles",
     *     @OA\Response(
     *         response=200,
     *         description="Listado completo",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/RolPermiso"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(RolPermiso::all(), 200);
    }

    /**
     * Asignar un permiso a un rol
     *
     * @OA\Post(
     *     path="/api/roles-permisos",
     *     tags={"RolPermiso"},
     *     summary="Asignar un permiso a un rol",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_rol", "id_permiso"},
     *             @OA\Property(property="id_rol", type="integer", example=2),
     *             @OA\Property(property="id_permiso", type="integer", example=5),
     *             @OA\Property(property="asignado_por", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Permiso asignado", @OA\JsonContent(ref="#/components/schemas/RolPermiso")),
     *     @OA\Response(response=422, description="Datos inválidos")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_rol' => 'required|exists:roles,id',
            'id_permiso' => 'required|exists:permisos,id',
            'asignado_por' => 'nullable|exists:usuarios,id'
        ]);

        $rolPermiso = RolPermiso::firstOrCreate([
            'id_rol' => $request->id_rol,
            'id_permiso' => $request->id_permiso
        ], [
            'asignado_por' => $request->asignado_por
        ]);

        return response()->json($rolPermiso, 201);
    }

    /**
     * Obtener todos los permisos de un rol específico
     *
     * @OA\Get(
     *     path="/api/roles-permisos/{id}",
     *     tags={"RolPermiso"},
     *     summary="Obtener permisos de un rol",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Permisos del rol",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Permiso"))
     *     ),
     *     @OA\Response(response=404, description="Rol no encontrado")
     * )
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
     * Deshabilitado: no se permite actualizar la relación
     *
     * @OA\Put(
     *     path="/api/roles-permisos/{id}",
     *     tags={"RolPermiso"},
     *     summary="❌ No se permite actualizar permisos de roles directamente",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=403, description="Actualización no permitida")
     * )
     */
    public function update(Request $request, $id)
    {
        return response()->json(['error' => 'No se permite actualizar registros de permisos de roles'], 403);
    }

    /**
     * Eliminar una asignación de permiso
     *
     * @OA\Delete(
     *     path="/api/roles-permisos/{id}",
     *     tags={"RolPermiso"},
     *     summary="Eliminar una asignación de permiso de un rol",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Permiso eliminado del rol",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Permiso eliminado del rol correctamente"))
     *     ),
     *     @OA\Response(response=404, description="Registro no encontrado")
     * )
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
