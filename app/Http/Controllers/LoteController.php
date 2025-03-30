<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lote;

/**
* @OA\Info(
*     title="API de Lotes",
*     version="1.0",
*     description="Gestión de lotes de productos"
* )
*
* @OA\Server(url="http://127.0.0.1:8000")
*/

/**
 * @OA\Schema(
 *     schema="Lote",
 *     type="object",
 *     required={"codigo_lote", "producto_id", "cantidad", "fecha_ingreso", "estado"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="codigo_lote", type="string", example="LT-001"),
 *     @OA\Property(property="producto_id", type="integer", example=2),
 *     @OA\Property(property="cantidad", type="integer", example=100),
 *     @OA\Property(property="fecha_ingreso", type="string", format="date", example="2024-03-25"),
 *     @OA\Property(property="fecha_vencimiento", type="string", format="date", example="2024-12-31"),
 *     @OA\Property(property="estado", type="string", enum={"disponible", "agotado", "vencido"}, example="disponible"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-25T10:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-25T11:00:00Z")
 * )
 */
class LoteController extends Controller
{
    /**
     * Listar todos los lotes
     *
     * @OA\Get(
     *     path="/lotes",
     *     tags={"Lotes"},
     *     summary="Listar todos los lotes",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de lotes",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Lote"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Lote::all(), 200);
    }

    /**
     * Crear un nuevo lote
     *
     * @OA\Post(
     *     path="/lotes",
     *     tags={"Lotes"},
     *     summary="Crear un nuevo lote",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"codigo_lote", "producto_id", "cantidad", "fecha_ingreso", "estado"},
     *             @OA\Property(property="codigo_lote", type="string", example="LT-001"),
     *             @OA\Property(property="producto_id", type="integer", example=2),
     *             @OA\Property(property="cantidad", type="integer", example=100),
     *             @OA\Property(property="fecha_ingreso", type="string", format="date", example="2024-03-25"),
     *             @OA\Property(property="fecha_vencimiento", type="string", format="date", example="2024-12-31"),
     *             @OA\Property(property="estado", type="string", enum={"disponible", "agotado", "vencido"}, example="disponible")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Lote creado",
     *         @OA\JsonContent(ref="#/components/schemas/Lote")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo_lote' => 'required|string|max:50',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'fecha_ingreso' => 'required|date',
            'fecha_vencimiento' => 'nullable|date',
            'estado' => 'required|in:disponible,agotado,vencido',
        ]);

        $lote = Lote::create($request->all());

        return response()->json($lote, 201);
    }

    /**
     * Ver un lote por ID
     *
     * @OA\Get(
     *     path="/lotes/{id}",
     *     tags={"Lotes"},
     *     summary="Obtener un lote específico",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Lote encontrado", @OA\JsonContent(ref="#/components/schemas/Lote")),
     *     @OA\Response(response=404, description="Lote no encontrado")
     * )
     */
    public function show($id)
    {
        $lote = Lote::find($id);

        if (!$lote) {
            return response()->json(['error' => 'Lote no encontrado'], 404);
        }

        return response()->json($lote);
    }

    /**
     * Actualizar un lote
     *
     * @OA\Put(
     *     path="/lotes/{id}",
     *     tags={"Lotes"},
     *     summary="Actualizar un lote",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="codigo_lote", type="string", example="LT-002"),
     *             @OA\Property(property="producto_id", type="integer", example=2),
     *             @OA\Property(property="cantidad", type="integer", example=200),
     *             @OA\Property(property="fecha_ingreso", type="string", format="date", example="2024-03-30"),
     *             @OA\Property(property="fecha_vencimiento", type="string", format="date", example="2025-01-01"),
     *             @OA\Property(property="estado", type="string", enum={"disponible", "agotado", "vencido"}, example="agotado")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Lote actualizado", @OA\JsonContent(ref="#/components/schemas/Lote")),
     *     @OA\Response(response=404, description="Lote no encontrado")
     * )
     */
    public function update(Request $request, $id)
    {
        $lote = Lote::find($id);

        if (!$lote) {
            return response()->json(['error' => 'Lote no encontrado'], 404);
        }

        $request->validate([
            'codigo_lote' => 'sometimes|string|max:50',
            'producto_id' => 'sometimes|exists:productos,id',
            'cantidad' => 'sometimes|integer|min:1',
            'fecha_ingreso' => 'sometimes|date',
            'fecha_vencimiento' => 'nullable|date',
            'estado' => 'sometimes|in:disponible,agotado,vencido',
        ]);

        $lote->update($request->all());

        return response()->json($lote);
    }

    /**
     * Eliminar un lote
     *
     * @OA\Delete(
     *     path="/lotes/{id}",
     *     tags={"Lotes"},
     *     summary="Eliminar un lote",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Lote eliminado",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Lote eliminado correctamente"))
     *     ),
     *     @OA\Response(response=404, description="Lote no encontrado")
     * )
     */
    public function destroy($id)
    {
        $lote = Lote::find($id);

        if (!$lote) {
            return response()->json(['error' => 'Lote no encontrado'], 404);
        }

        $lote->delete();

        return response()->json(['message' => 'Lote eliminado correctamente']);
    }
}
