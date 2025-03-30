<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permiso;

/**
* @OA\Info(
*     title="API de Permisos",
*     version="1.0",
*     description="Gestión de permisos para el control de acceso"
* )
*
* @OA\Server(url="http://127.0.0.1:8000")
*/

/**
 * @OA\Schema(
 *     schema="Permiso",
 *     type="object",
 *     required={"nombre", "modulo"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="crear_usuario"),
 *     @OA\Property(property="modulo", type="string", example="Usuarios"),
 *     @OA\Property(property="descripcion", type="string", example="Permite crear un nuevo usuario"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class PermisoController extends Controller
{
    /**
     * Listar todos los permisos
     *
     * @OA\Get(
     *     path="/api/permisos",
     *     tags={"Permisos"},
     *     summary="Obtener todos los permisos",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de permisos",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Permiso"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Permiso::all(), 200);
    }

    /**
     * Crear un nuevo permiso
     *
     * @OA\Post(
     *     path="/api/permisos",
     *     tags={"Permisos"},
     *     summary="Registrar un nuevo permiso",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "modulo"},
     *             @OA\Property(property="nombre", type="string", example="editar_producto"),
     *             @OA\Property(property="modulo", type="string", example="Productos"),
     *             @OA\Property(property="descripcion", type="string", example="Permite editar productos")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Permiso creado",
     *         @OA\JsonContent(ref="#/components/schemas/Permiso")
     *     ),
     *     @OA\Response(response=422, description="Datos inválidos")
     * )
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
     * Obtener un permiso por ID
     *
     * @OA\Get(
     *     path="/api/permisos/{id}",
     *     tags={"Permisos"},
     *     summary="Consultar un permiso por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Permiso encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Permiso")
     *     ),
     *     @OA\Response(response=404, description="Permiso no encontrado")
     * )
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
     * Actualizar un permiso
     *
     * @OA\Put(
     *     path="/api/permisos/{id}",
     *     tags={"Permisos"},
     *     summary="Actualizar permiso existente",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="eliminar_usuario"),
     *             @OA\Property(property="modulo", type="string", example="Usuarios"),
     *             @OA\Property(property="descripcion", type="string", example="Permite eliminar un usuario")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Permiso actualizado", @OA\JsonContent(ref="#/components/schemas/Permiso")),
     *     @OA\Response(response=404, description="Permiso no encontrado")
     * )
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
     * Eliminar un permiso
     *
     * @OA\Delete(
     *     path="/api/permisos/{id}",
     *     tags={"Permisos"},
     *     summary="Eliminar un permiso",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Permiso eliminado",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Permiso eliminado correctamente"))
     *     ),
     *     @OA\Response(response=404, description="Permiso no encontrado")
     * )
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
