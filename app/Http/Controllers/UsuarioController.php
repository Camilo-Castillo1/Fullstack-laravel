<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;




/**
 * @OA\Schema(
 *     schema="Usuario",
 *     type="object",
 *     required={"nombre", "apellido", "correo", "password", "id_rol", "estado"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Carlos"),
 *     @OA\Property(property="apellido", type="string", example="Pérez"),
 *     @OA\Property(property="correo", type="string", format="email", example="carlos.perez@example.com"),
 *     @OA\Property(property="telefono", type="string", example="3001234567"),
 *     @OA\Property(property="id_rol", type="integer", example=2),
 *     @OA\Property(property="estado", type="string", enum={"activo", "inactivo"}, example="activo"),
 *     @OA\Property(property="ultimo_acceso", type="string", format="date-time", example="2024-03-30T12:00:00Z"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class UsuarioController extends Controller
{
    /**
     * Listar todos los usuarios
     *
     * @OA\Get(
     *     path="/usuarios",
     *     tags={"Usuarios"},
     *     summary="Obtener lista de todos los usuarios",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuarios",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Usuario"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Usuario::all(), 200);
    }

    /**
     * Crear un nuevo usuario
     *
     * @OA\Post(
     *     path="/usuarios",
     *     tags={"Usuarios"},
     *     summary="Registrar un nuevo usuario",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "apellido", "correo", "password", "id_rol", "estado"},
     *             @OA\Property(property="nombre", type="string", example="Juan"),
     *             @OA\Property(property="apellido", type="string", example="Gómez"),
     *             @OA\Property(property="correo", type="string", example="juan@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret123"),
     *             @OA\Property(property="telefono", type="string", example="3216549870"),
     *             @OA\Property(property="id_rol", type="integer", example=1),
     *             @OA\Property(property="estado", type="string", example="activo")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Usuario creado", @OA\JsonContent(ref="#/components/schemas/Usuario")),
     *     @OA\Response(response=422, description="Datos inválidos")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo',
            'password' => 'required|string|min:6',
            'telefono' => 'nullable|string|max:20',
            'id_rol' => 'required|exists:roles,id',
            'estado' => 'required|in:activo,inactivo'
        ]);

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'id_rol' => $request->id_rol,
            'estado' => $request->estado,
            'ultimo_acceso' => now()
        ]);

        return response()->json($usuario, 201);
    }

    /**
     * Obtener un usuario por ID
     *
     * @OA\Get(
     *     path="/usuarios/{id}",
     *     tags={"Usuarios"},
     *     summary="Consultar usuario por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Usuario encontrado", @OA\JsonContent(ref="#/components/schemas/Usuario")),
     *     @OA\Response(response=404, description="Usuario no encontrado")
     * )
     */
    public function show($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return response()->json($usuario);
    }

    /**
     * Actualizar un usuario existente
     *
     * @OA\Put(
     *     path="/usuarios/{id}",
     *     tags={"Usuarios"},
     *     summary="Actualizar un usuario",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Juan"),
     *             @OA\Property(property="apellido", type="string", example="Gómez"),
     *             @OA\Property(property="correo", type="string", example="juan.cambio@example.com"),
     *             @OA\Property(property="password", type="string", example="nuevaClave123"),
     *             @OA\Property(property="estado", type="string", example="activo")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Usuario actualizado", @OA\JsonContent(ref="#/components/schemas/Usuario")),
     *     @OA\Response(response=404, description="Usuario no encontrado")
     * )
     */
    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'apellido' => 'sometimes|string|max:255',
            'correo' => 'sometimes|email|unique:usuarios,correo,' . $id,
            'password' => 'sometimes|string|min:6',
            'telefono' => 'sometimes|string|max:20',
            'id_rol' => 'sometimes|exists:roles,id',
            'estado' => 'sometimes|in:activo,inactivo'
        ]);

        if ($request->has('password')) {
            $request->merge(['password' => Hash::make($request->password)]);
        }

        $usuario->update($request->all());

        return response()->json($usuario);
    }

    /**
     * Eliminar un usuario
     *
     * @OA\Delete(
     *     path="/usuarios/{id}",
     *     tags={"Usuarios"},
     *     summary="Eliminar un usuario por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario eliminado",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Usuario eliminado correctamente"))
     *     ),
     *     @OA\Response(response=404, description="Usuario no encontrado")
     * )
     */
    public function destroy($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $usuario->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }
}
