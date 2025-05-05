<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PoliticaInventario;



/**
 * @OA\Schema(
 *     schema="PoliticaInventario",
 *     type="object",
 *     required={"nombre", "tipo", "aplicable_a", "fecha_implementacion", "ubicacion_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Política PEPS"),
 *     @OA\Property(property="tipo", type="string", enum={"PEPS", "UEPS", "FIFO"}, example="PEPS"),
 *     @OA\Property(property="aplicable_a", type="string", enum={"refrigerado", "seco", "congelado"}, example="seco"),
 *     @OA\Property(property="fecha_implementacion", type="string", format="date", example="2024-03-30"),
 *     @OA\Property(property="ubicacion_id", type="integer", example=2),
 *     @OA\Property(property="categoria_id", type="integer", nullable=true, example=3),
 *     @OA\Property(property="almacen_id", type="integer", nullable=true, example=5),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class PoliticaInventarioController extends Controller
{
    /**
     * Listar todas las políticas
     *
     * @OA\Get(
     *     path="/politicas-inventario",
     *     tags={"PoliticasInventario"},
     *     summary="Listar todas las políticas de inventario",
     *     @OA\Response(
     *         response=200,
     *         description="Listado de políticas",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/PoliticaInventario"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(PoliticaInventario::all(), 200);
    }

    /**
     * Crear una nueva política de inventario
     *
     * @OA\Post(
     *     path="/politicas-inventario",
     *     tags={"PoliticasInventario"},
     *     summary="Crear nueva política de inventario",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "tipo", "aplicable_a", "fecha_implementacion", "ubicacion_id"},
     *             @OA\Property(property="nombre", type="string", example="Política FIFO"),
     *             @OA\Property(property="tipo", type="string", enum={"PEPS", "UEPS", "FIFO"}, example="FIFO"),
     *             @OA\Property(property="aplicable_a", type="string", enum={"refrigerado", "seco", "congelado"}, example="refrigerado"),
     *             @OA\Property(property="fecha_implementacion", type="string", format="date", example="2024-04-01"),
     *             @OA\Property(property="ubicacion_id", type="integer", example=2),
     *             @OA\Property(property="categoria_id", type="integer", example=1),
     *             @OA\Property(property="almacen_id", type="integer", example=4)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Política creada", @OA\JsonContent(ref="#/components/schemas/PoliticaInventario")),
     *     @OA\Response(response=422, description="Datos inválidos")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'tipo' => 'required|in:PEPS,UEPS,FIFO',
            'aplicable_a' => 'required|in:producto,lote,almacen',
            'valor' => 'required|integer|min:1', 
            'fecha_implementacion' => 'nullable|date',
            'ubicacion_id' => 'required|exists:ubicaciones_almacenamiento,id',
            'categoria_id' => 'nullable|exists:categorias,id',
            'almacen_id' => 'nullable|exists:almacenes,id',
        ]);

        $politica = PoliticaInventario::create($request->all());

        return response()->json($politica, 201);
    }

    /**
     * Obtener una política por ID
     *
     * @OA\Get(
     *     path="/politicas-inventario/{id}",
     *     tags={"PoliticasInventario"},
     *     summary="Consultar política por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Política encontrada", @OA\JsonContent(ref="#/components/schemas/PoliticaInventario")),
     *     @OA\Response(response=404, description="Política no encontrada")
     * )
     */
    public function show($id)
    {
        $politica = PoliticaInventario::find($id);

        if (!$politica) {
            return response()->json(['error' => 'Política de inventario no encontrada'], 404);
        }

        return response()->json($politica);
    }

    /**
     * Actualizar una política existente
     *
     * @OA\Put(
     *     path="/politicas-inventario/{id}",
     *     tags={"PoliticasInventario"},
     *     summary="Actualizar una política de inventario",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Política PEPS Actualizada"),
     *             @OA\Property(property="tipo", type="string", enum={"PEPS", "UEPS", "FIFO"}, example="UEPS"),
     *             @OA\Property(property="aplicable_a", type="string", enum={"refrigerado", "seco", "congelado"}, example="congelado"),
     *             @OA\Property(property="fecha_implementacion", type="string", format="date", example="2024-04-15"),
     *             @OA\Property(property="ubicacion_id", type="integer", example=2),
     *             @OA\Property(property="categoria_id", type="integer", example=3),
     *             @OA\Property(property="almacen_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Política actualizada", @OA\JsonContent(ref="#/components/schemas/PoliticaInventario")),
     *     @OA\Response(response=404, description="Política no encontrada")
     * )
     */
    public function update(Request $request, $id)
    {
        $politica = PoliticaInventario::find($id);

        if (!$politica) {
            return response()->json(['error' => 'Política de inventario no encontrada'], 404);
        }

        $request->validate([
            'nombre' => 'required|string|max:50',
            'tipo' => 'required|in:PEPS,UEPS,FIFO',
            'aplicable_a' => 'required|in:producto,lote,almacen',
            'valor' => 'required|integer|min:1', 
            'fecha_implementacion' => 'nullable|date',
            'ubicacion_id' => 'required|exists:ubicaciones_almacenamiento,id',
            'categoria_id' => 'nullable|exists:categorias,id',
            'almacen_id' => 'nullable|exists:almacenes,id',
        ]);
        

        $politica->update($request->all());

        return response()->json($politica);
    }

    /**
     * Eliminar una política de inventario
     *
     * @OA\Delete(
     *     path="/politicas-inventario/{id}",
     *     tags={"PoliticasInventario"},
     *     summary="Eliminar una política",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Política eliminada",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Política de inventario eliminada correctamente"))
     *     ),
     *     @OA\Response(response=404, description="Política no encontrada")
     * )
     */
    public function destroy($id)
    {
        $politica = PoliticaInventario::find($id);

        if (!$politica) {
            return response()->json(['error' => 'Política de inventario no encontrada'], 404);
        }

        $politica->delete();

        return response()->json(['message' => 'Política de inventario eliminada correctamente']);
    }
}
