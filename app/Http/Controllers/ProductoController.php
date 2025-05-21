<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Mostrar listado de productos (con búsqueda por nombre).
     */
    public function index(Request $request)
    {
        $busqueda = $request->input('buscar');

        $productos = Producto::with('categoria')
            ->when($busqueda, function ($query, $busqueda) {
                $query->where('nombre', 'like', "%{$busqueda}%");
            })
            ->get();

        return view('productos.index', compact('productos', 'busqueda'));
    }

    /**
     * Mostrar formulario de creación de producto.
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    /**
     * Guardar un nuevo producto.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo_producto' => 'required|string|max:50|unique:productos,codigo_producto',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'precio_unitario' => 'required|numeric|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'estado' => 'required|in:activo,inactivo',
        ]);

        Producto::create($request->all());

        return redirect()->route('admin.productos.index')->with('success', 'Producto creado correctamente.');
    }

    /**
     * Mostrar formulario de edición de producto.
     */
    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Actualizar producto existente.
     */
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'codigo_producto' => 'required|string|max:50|unique:productos,codigo_producto,' . $producto->id,
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'precio_unitario' => 'required|numeric|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $producto->update($request->all());

        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Eliminar producto.
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado.');
    }
}
