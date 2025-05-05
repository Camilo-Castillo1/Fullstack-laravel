<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;



/**
 * @OA\Schema(
 *     schema="Producto",
 *     type="object",
 *     required={"codigo_producto", "nombre", "categoria_id", "precio_unitario", "stock_minimo", "estado"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="codigo_producto", type="string", example="PRD-001"),
 *     @OA\Property(property="nombre", type="string", example="Botella de agua 600ml"),
 *     @OA\Property(property="categoria_id", type="integer", example=2),
 *     @OA\Property(property="precio_unitario", type="number", format="float", example=1500.00),
 *     @OA\Property(property="stock_minimo", type="integer", example=10),
 *     @OA\Property(property="estado", type="string", enum={"activo", "inactivo"}, example="activo"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class ProductoController extends Controller
{
    /**
     * Listar todos los productos
     *
     * @OA\Get(
     *     path="/productos",
     *     tags={"Productos"},
     *     summary="Obtener todos los productos",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de productos",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Producto"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Producto::all());
    }

    /**
     * Crear un nuevo producto
     *
     * @OA\Post(
     *     path="/productos",
     *     tags={"Productos"},
     *     summary="Registrar un nuevo producto",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"codigo_producto", "nombre", "categoria_id", "precio_unitario", "stock_minimo", "estado"},
     *             @OA\Property(property="codigo_producto", type="string", example="PRD-002"),
     *             @OA\Property(property="nombre", type="string", example="Aceite vegetal 1L"),
     *             @OA\Property(property="categoria_id", type="integer", example=1),
     *             @OA\Property(property="precio_unitario", type="number", format="float", example=7200.50),
     *             @OA\Property(property="stock_minimo", type="integer", example=25),
     *             @OA\Property(property="estado", type="string", enum={"activo", "inactivo"}, example="activo")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Producto creado", @OA\JsonContent(ref="#/components/schemas/Producto")),
     *     @OA\Response(response=422, description="Datos inválidos")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo_producto' => 'required|unique:productos',
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'precio_unitario' => 'required|numeric',
            'stock_minimo' => 'required|integer',
            'estado' => 'required|in:activo,inactivo'
        ]);

        $producto = Producto::create($request->all());

        return response()->json($producto, 201);
    }

    /**
     * Obtener un producto por ID
     *
     * @OA\Get(
     *     path="/productos/{id}",
     *     tags={"Productos"},
     *     summary="Consultar un producto por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Producto encontrado", @OA\JsonContent(ref="#/components/schemas/Producto")),
     *     @OA\Response(response=404, description="Producto no encontrado")
     * )
     */
    public function show($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        return response()->json($producto);
    }

    /**
     * Actualizar un producto
     *
     * @OA\Put(
     *     path="/productos/{id}",
     *     tags={"Productos"},
     *     summary="Actualizar un producto",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Botella de agua 1L"),
     *             @OA\Property(property="precio_unitario", type="number", example=1800),
     *             @OA\Property(property="estado", type="string", example="activo")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Producto actualizado", @OA\JsonContent(ref="#/components/schemas/Producto")),
     *     @OA\Response(response=404, description="Producto no encontrado")
     * )
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        $producto->update($request->all());

        return response()->json($producto);
    }

    /**
     * Eliminar un producto
     *
     * @OA\Delete(
     *     path="/productos/{id}",
     *     tags={"Productos"},
     *     summary="Eliminar un producto",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Producto eliminado",
     *         @OA\JsonContent(@OA\Property(property="message", type="string", example="Producto eliminado correctamente"))
     *     ),
     *     @OA\Response(response=404, description="Producto no encontrado")
     * )
     */
    public function destroy($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        $producto->delete();

        return response()->json(['message' => 'Producto eliminado correctamente']);
    }
}
