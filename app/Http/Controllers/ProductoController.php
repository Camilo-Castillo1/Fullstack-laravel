<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    /**
     * 📌 Listar todos los productos
     */
    public function index()
    {
        return response()->json(Producto::all());
    }

    /**
     * 📌 Crear un nuevo producto
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
     * 📌 Obtener un producto por ID
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
     * 📌 Actualizar un producto
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
     * 📌 Eliminar un producto
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
