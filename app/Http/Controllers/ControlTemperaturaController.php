<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ControlTemperatura;

/**
* @OA\Info(
*     title="API de Control de Temperatura",
*     version="1.0",
*     description="Documentación de la API para el control de temperaturas en almacenes"
* )
*
* @OA\Server(
*     url="http://127.0.0.1:8000"
* )
*/

/**
 * @OA\Schema(
 *     schema="ControlTemperatura",
 *     type="object",
 *     required={"almacen_id", "temperatura"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="almacen_id", type="integer", example=3),
 *     @OA\Property(property="temperatura", type="number", format="float", example=18.5),
 *     @OA\Property(property="fecha_registro", type="string", format="date-time", example="2024-03-25T08:00:00Z"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-25T08:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-25T08:00:00Z")
 * )
 */
class ControlTemperaturaController extends Controller
{
    /**
     * Listar todos los registros de temperatura
     *
     * @OA\Get(
     *     path="/control-temperaturas",
     *     tags={"ControlTemperatura"},
     *     summary="Obtener todos los registros de temperatura",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de registros",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ControlTemperatura")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(ControlTemperatura::all(), 200);
    }

    /**
     * Crear un nuevo registro de temperatura
     *
     * @OA\Post(
     *     path="/control-temperaturas",
     *     tags={"ControlTemperatura"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"almacen_id", "temperatura"},
     *             @OA\Property(property="almacen_id", type="integer", example=3),
     *             @OA\Property(property="temperatura", type="number", format="float", example=18.5)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Registro creado",
     *         @OA\JsonContent(ref="#/components/schemas/ControlTemperatura")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos inválidos"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'almacen_id' => 'required|exists:almacenes,id',
            'temperatura' => 'required|numeric|min:-50|max:100',
        ]);

        $controlTemperatura = ControlTemperatura::create([
            'almacen_id' => $request->almacen_id,
            'temperatura' => $request->temperatura,
            'fecha_registro' => now()
        ]);

        return response()->json($controlTemperatura, 201);
    }

    /**
     * Obtener un registro de temperatura por ID
     *
     * @OA\Get(
     *     path="/control-temperaturas/{id}",
     *     tags={"ControlTemperatura"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registro encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/ControlTemperatura")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Registro no encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        $controlTemperatura = ControlTemperatura::find($id);

        if (!$controlTemperatura) {
            return response()->json(['error' => 'Registro de temperatura no encontrado'], 404);
        }

        return response()->json($controlTemperatura);
    }

    /**
     * Actualizar un registro de temperatura
     *
     * @OA\Put(
     *     path="/control-temperaturas/{id}",
     *     tags={"ControlTemperatura"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="almacen_id", type="integer", example=3),
     *             @OA\Property(property="temperatura", type="number", format="float", example=22.0)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registro actualizado",
     *         @OA\JsonContent(ref="#/components/schemas/ControlTemperatura")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Registro no encontrado"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $controlTemperatura = ControlTemperatura::find($id);

        if (!$controlTemperatura) {
            return response()->json(['error' => 'Registro de temperatura no encontrado'], 404);
        }

        $request->validate([
            'almacen_id' => 'sometimes|exists:almacenes,id',
            'temperatura' => 'sometimes|numeric|min:-50|max:100',
        ]);

        $controlTemperatura->update($request->all());

        return response()->json($controlTemperatura);
    }

    /**
     * Eliminar un registro de temperatura
     *
     * @OA\Delete(
     *     path="/control-temperaturas/{id}",
     *     tags={"ControlTemperatura"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registro eliminado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Registro de temperatura eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Registro no encontrado"
     *     )
     * )
     */
    public function destroy($id)
    {
        $controlTemperatura = ControlTemperatura::find($id);

        if (!$controlTemperatura) {
            return response()->json(['error' => 'Registro de temperatura no encontrado'], 404);
        }

        $controlTemperatura->delete();

        return response()->json(['message' => 'Registro de temperatura eliminado correctamente']);
    }
}
