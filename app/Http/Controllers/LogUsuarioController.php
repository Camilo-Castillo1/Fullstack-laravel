<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogUsuario;

/**
* @OA\Info(
*     title="API de Logs de Usuario",
*     version="1.0",
*     description="Registra y consulta logs de actividad de usuarios"
* )
*
* @OA\Server(url="http://127.0.0.1:8000")
*/

/**
 * @OA\Schema(
 *     schema="LogUsuario",
 *     type="object",
 *     required={"id_usuario", "tipo_evento"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="id_usuario", type="integer", example=5),
 *     @OA\Property(property="tipo_evento", type="string", enum={"INSERT", "UPDATE", "DELETE"}, example="UPDATE"),
 *     @OA\Property(property="campo_modificado", type="string", example="email"),
 *     @OA\Property(property="valor_anterior", type="string", example="correo@viejo.com"),
 *     @OA\Property(property="valor_nuevo", type="string", example="correo@nuevo.com"),
 *     @OA\Property(property="usuario_modifico", type="integer", example=1),
 *     @OA\Property(property="fecha_evento", type="string", format="date-time", example="2024-03-25T12:00:00Z"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class LogUsuarioController extends Controller
{
    /**
     * Listar todos los logs de usuarios
     *
     * @OA\Get(
     *     path="/api/logs-usuario",
     *     tags={"LogUsuario"},
     *     summary="Listar logs de usuarios",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de logs",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/LogUsuario"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(LogUsuario::all(), 200);
    }

    /**
     * Crear un nuevo registro de log
     *
     * @OA\Post(
     *     path="/api/logs-usuario",
     *     tags={"LogUsuario"},
     *     summary="Registrar un nuevo evento en el log",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_usuario", "tipo_evento"},
     *             @OA\Property(property="id_usuario", type="integer", example=5),
     *             @OA\Property(property="tipo_evento", type="string", enum={"INSERT", "UPDATE", "DELETE"}, example="UPDATE"),
     *             @OA\Property(property="campo_modificado", type="string", example="email"),
     *             @OA\Property(property="valor_anterior", type="string", example="correo@viejo.com"),
     *             @OA\Property(property="valor_nuevo", type="string", example="correo@nuevo.com"),
     *             @OA\Property(property="usuario_modifico", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Log registrado", @OA\JsonContent(ref="#/components/schemas/LogUsuario")),
     *     @OA\Response(response=422, description="Datos inválidos")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id',
            'tipo_evento' => 'required|in:INSERT,UPDATE,DELETE',
            'campo_modificado' => 'nullable|string|max:50',
            'valor_anterior' => 'nullable|string',
            'valor_nuevo' => 'nullable|string',
            'usuario_modifico' => 'nullable|exists:usuarios,id'
        ]);

        $log = LogUsuario::create([
            'id_usuario' => $request->id_usuario,
            'tipo_evento' => $request->tipo_evento,
            'campo_modificado' => $request->campo_modificado,
            'valor_anterior' => $request->valor_anterior,
            'valor_nuevo' => $request->valor_nuevo,
            'usuario_modifico' => $request->usuario_modifico,
            'fecha_evento' => now()
        ]);

        return response()->json($log, 201);
    }

    /**
     * Obtener un log por ID
     *
     * @OA\Get(
     *     path="/api/logs-usuario/{id}",
     *     tags={"LogUsuario"},
     *     summary="Obtener log específico",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Log encontrado", @OA\JsonContent(ref="#/components/schemas/LogUsuario")),
     *     @OA\Response(response=404, description="Log no encontrado")
     * )
     */
    public function show($id)
    {
        $log = LogUsuario::find($id);

        if (!$log) {
            return response()->json(['error' => 'Registro de log no encontrado'], 404);
        }

        return response()->json($log);
    }

    /**
     * No se permite actualizar registros de log
     *
     * @OA\Put(
     *     path="/api/logs-usuario/{id}",
     *     tags={"LogUsuario"},
     *     summary="(Deshabilitado) Intento de actualizar log",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=403, description="Actualización no permitida")
     * )
     */
    public function update(Request $request, $id)
    {
        return response()->json(['error' => 'No se permite actualizar registros de log'], 403);
    }

    /**
     * No se permite eliminar registros de log
     *
     * @OA\Delete(
     *     path="/api/logs-usuario/{id}",
     *     tags={"LogUsuario"},
     *     summary="(Deshabilitado) Intento de eliminar log",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=403, description="Eliminación no permitida")
     * )
     */
    public function destroy($id)
    {
        return response()->json(['error' => 'No se permite eliminar registros de log'], 403);
    }
}
