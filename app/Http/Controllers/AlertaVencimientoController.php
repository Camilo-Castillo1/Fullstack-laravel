<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlertaVencimiento;

/**
* @OA\Info(
*     title="API de Alertas de Vencimiento",
*     version="1.0",
*     description="Gestión de alertas para vencimientos de lotes"
* )
*
* @OA\Server(
*     url="http://127.0.0.1:8000"
* )
*/

/**
 * @OA\Schema(
 *     schema="AlertaVencimiento",
 *     type="object",
 *     required={"lote_id", "fecha_vencimiento", "estado"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="lote_id", type="integer", example=10),
 *     @OA\Property(property="fecha_vencimiento", type="string", format="date", example="2024-12-31"),
 *     @OA\Property(property="fecha_alerta_generada", type="string", format="date-time", example="2024-03-25T12:00:00Z"),
 *     @OA\Property(property="estado", type="string", enum={"pendiente", "atendida"}, example="pendiente")
 * )
 */
class AlertaVencimientoController extends Controller
{
    /**
     * Listar todas las alertas
     *
     * @OA\Get(
     *     path="/api/alertas-vencimiento",
     *     tags={"AlertaVencimiento"},
     *     summary="Listar todas las alertas de vencimiento",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de alertas",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/AlertaVencimiento"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(AlertaVencimiento::all(), 200);
    }

    /**
     * Crear nueva alerta
     *
     * @OA\Post(
     *     path="/alertas-vencimiento",
     *     tags={"AlertaVencimiento"},
     *     summary="Crear una nueva alerta",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"lote_id", "fecha_vencimiento", "estado"},
     *             @OA\Property(property="lote_id", type="integer", example=10),
     *             @OA\Property(property="fecha_vencimiento", type="string", format="date", example="2024-12-31"),
     *             @OA\Property(property="estado", type="string", enum={"pendiente", "atendida"}, example="pendiente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Alerta creada",
     *         @OA\JsonContent(ref="#/components/schemas/AlertaVencimiento")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'lote_id' => 'required|exists:lotes,id',
            'fecha_vencimiento' => 'required|date',
            'estado' => 'required|in:pendiente,atendida',
        ]);

        $alerta = AlertaVencimiento::create([
            'lote_id' => $request->lote_id,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'estado' => $request->estado,
            'fecha_alerta_generada' => now(),
        ]);

        return response()->json($alerta, 201);
    }

    /**
     * Ver una alerta por ID
     *
     * @OA\Get(
     *     path="/alertas-vencimiento/{id}",
     *     tags={"AlertaVencimiento"},
     *     summary="Obtener una alerta específica",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Alerta encontrada",
     *         @OA\JsonContent(ref="#/components/schemas/AlertaVencimiento")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Alerta no encontrada"
     *     )
     * )
     */
    public function show($id)
    {
        $alerta = AlertaVencimiento::find($id);

        if (!$alerta) {
            return response()->json(['error' => 'Alerta no encontrada'], 404);
        }

        return response()->json($alerta);
    }

    /**
     * Actualizar una alerta
     *
     * @OA\Put(
     *     path="/alertas-vencimiento/{id}",
     *     tags={"AlertaVencimiento"},
     *     summary="Actualizar alerta por ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="fecha_vencimiento", type="string", format="date", example="2025-01-15"),
     *             @OA\Property(property="estado", type="string", enum={"pendiente", "atendida"}, example="atendida")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Alerta actualizada",
     *         @OA\JsonContent(ref="#/components/schemas/AlertaVencimiento")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Alerta no encontrada"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $alerta = AlertaVencimiento::find($id);

        if (!$alerta) {
            return response()->json(['error' => 'Alerta no encontrada'], 404);
        }

        $request->validate([
            'fecha_vencimiento' => 'sometimes|date',
            'estado' => 'sometimes|in:pendiente,atendida',
        ]);

        $alerta->update($request->all());

        return response()->json($alerta);
    }

    /**
     * Eliminar una alerta
     *
     * @OA\Delete(
     *     path="/alertas-vencimiento/{id}",
     *     tags={"AlertaVencimiento"},
     *     summary="Eliminar una alerta",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Alerta eliminada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Alerta eliminada correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Alerta no encontrada"
     *     )
     * )
     */
    public function destroy($id)
    {
        $alerta = AlertaVencimiento::find($id);

        if (!$alerta) {
            return response()->json(['error' => 'Alerta no encontrada'], 404);
        }

        $alerta->delete();

        return response()->json(['message' => 'Alerta eliminada correctamente']);
    }
}
