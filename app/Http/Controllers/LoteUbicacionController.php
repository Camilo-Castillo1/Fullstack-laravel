<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoteUbicacion;

/**
* @OA\Info(
*     title="API de Lote - Ubicación",
*     version="1.0",
*     description="Gestión de relación entre lotes y ubicaciones de almacenamiento"
* )
*
* @OA\Server(url="http://127.0.0.1:8000")
*/

/**
 * @OA\Schema(
 *     schema="LoteUbicacion",
 *     type="object",
 *     required={"id_lote", "id_ubicacion"},
 *     @OA\Property(property="id_lote", type="integer", example=1),
 *     @OA\Property(property="id_ubicacion", type="integer", example=2),
 *     @OA\Property(property="cantidad", type="integer", example=100),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-25T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-25T12:30:00Z")
 * )
 */
class LoteUbicacionController extends Controller
{
    /**
     * Listar todas las relaciones lote-ubicación
     *
     * @OA\Get(
     *     path="/lote-ubicacion",
     *     tags={"LoteUbicacion"},
     *     summary="Listar todas las ubicaciones por lote",
     *     @OA\Response(
     *         response=200,
     *         description="Listado completo",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/LoteUbicacion"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(LoteUbicacion::all(), 200);
    }

    /**
     * Registrar una nueva ubicación para un lote
     *
     * @OA\Post(
     *     path="/lote-ubicacion",
     *     tags={"LoteUbicacion"},
     *     summary="Crear nueva asignación de lote a ubicación",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_lote", "id_ubicacion"},
     *             @OA\Property(property="id_lote", type="integer", example=1),
     *             @OA\Property(property="id_ubicacion", type="integer", example=2),
     *             @OA\Property(property="cantidad", type="integer", example=100)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Relación creada",
     *         @OA\JsonContent(ref="#/components/schemas/LoteUbicacion")
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
            'id_lote' => 'required|exists:lotes,id',
            'id_ubicacion' => 'required|exists:ubicaciones_almacenamiento,id',
            'cantidad' => 'nullable|integer|min:0',
        ]);

        $ubicacion = LoteUbicacion::create($request->all());

        return response()->json($ubicacion, 201);
    }

    /**
     * Consultar una relación lote-ubicación específica
     *
     * @OA\Get(
     *     path="/lote-ubicacion/{id_lote}/{id_ubicacion}",
     *     tags={"LoteUbicacion"},
     *     summary="Obtener relación específica entre lote y ubicación",
     *     @OA\Parameter(name="id_lote", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="id_ubicacion", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Relación encontrada",
     *         @OA\JsonContent(ref="#/components/schemas/LoteUbicacion")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No encontrada"
     *     )
     * )
     */
    public function show($id_lote, $id_ubicacion)
    {
        $loteUbicacion = LoteUbicacion::where('id_lote', $id_lote)
                                ->where('id_ubicacion', $id_ubicacion)
                                ->first();

        if (!$loteUbicacion) {
            return response()->json(['error' => 'Relación no encontrada'], 404);
        }

        return response()->json($loteUbicacion);
    }

    /**
     * Actualizar cantidad en una relación lote-ubicación
     *
     * @OA\Put(
     *     path="/lote-ubicacion/{id_lote}/{id_ubicacion}",
     *     tags={"LoteUbicacion"},
     *     summary="Actualizar cantidad en una ubicación de lote",
     *     @OA\Parameter(name="id_lote", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="id_ubicacion", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="cantidad", type="integer", example=150)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Relación actualizada",
     *         @OA\JsonContent(ref="#/components/schemas/LoteUbicacion")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Relación no encontrada"
     *     )
     * )
     */
    public function update(Request $request, $id_lote, $id_ubicacion)
    {
        $loteUbicacion = LoteUbicacion::where('id_lote', $id_lote)
                                    ->where('id_ubicacion', $id_ubicacion)
                                    ->first();

        if (!$loteUbicacion) {
            return response()->json(['error' => 'Relación no encontrada'], 404);
        }

        $request->validate([
            'cantidad' => 'sometimes|integer|min:0',
        ]);

        $loteUbicacion->update($request->all());

        return response()->json($loteUbicacion);
    }

    /**
     * Eliminar una relación lote-ubicación
     *
     * @OA\Delete(
     *     path="/lote-ubicacion/{id_lote}/{id_ubicacion}",
     *     tags={"LoteUbicacion"},
     *     summary="Eliminar relación entre lote y ubicación",
     *     @OA\Parameter(name="id_lote", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="id_ubicacion", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Relación eliminada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Relación eliminada correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Relación no encontrada"
     *     )
     * )
     */
    public function destroy($id_lote, $id_ubicacion)
    {
        $loteUbicacion = LoteUbicacion::where('id_lote', $id_lote)
                                ->where('id_ubicacion', $id_ubicacion)
                                ->first();

        if (!$loteUbicacion) {
            return response()->json(['error' => 'Relación no encontrada'], 404);
        }

        $loteUbicacion->delete();

        return response()->json(['message' => 'Relación eliminada correctamente']);
    }
}
