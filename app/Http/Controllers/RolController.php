<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol;

/**
* @OA\Info(
*     title="API de Roles",
*     version="1.0",
*     description="Gestión de roles de usuario"
* )
*
* @OA\Server(url="http://127.0.0.1:8000")
*/

/**
 * @OA\Schema(
 *     schema="Rol",
 *     type="object",
 *     required={"nombre"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Administrador"),
 *     @OA\Property(property="descripcion", type="string", example="Rol con acceso total al sistema"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class RolController extends Controller
{
    /**
     * Listar todos los roles
     *
     * @OA\Get(
     *     path="/api/roles",
     *     tags={"Roles"},
     *     summary="Listar todos los roles",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de roles",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Rol"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Rol::all(), 200);
    }

    /**
     * Crear un nuevo rol
     *
     * @OA\Post(
     *     path="/api/roles",
     *     tags={"Roles"},
     *     summary="Crear nuevo rol",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre"},
     *             @OA\Property(property="nombre", type="string", example="Supervisor"),
     *             @OA\Property(property="descripcion", type="string", example="Encargado de área logística")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Rol creado", @OA\JsonContent(ref="#/components/schemas/Rol")),
     *     @OA\Response(response=422, description="Datos inválidos")
     * )
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
     * Obtener un rol por ID
     *
     * @OA\Get(
     *     path="/api/roles/{id}",
     *     tags={"Roles"},
     *     summary="Consultar un rol por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Rol encontrado", @OA\JsonContent(ref="#/components/schemas/Rol")),
     *     @OA\Response(response=404, description="Rol no encontrado")
     * )
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
     * Actualizar un rol existente
     *
     * @OA\Put(
     *     path="/api/roles/{id}",
     *     tags={"Roles"},
     *     summary="Actualizar un rol",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Administrador"),
     *             @OA\Property(property="descripcion", type="string", example="Rol con acceso total")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Rol actualizado", @OA\JsonContent(ref="#/components/schemas/Rol")),
     *     @OA\Response(response=404, description="Rol no encontrado")
     * )
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
     * Eliminar un rol
     *
     * @OA\Delete(
     *     path="/api/roles/{id}",
     *     tags={"Roles"},
     *     summary="Eliminar un rol",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Rol eliminado",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Rol eliminado correctamente"))
     *     ),
     *     @OA\Response(response=404, description="Rol no encontrado")
     * )
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
