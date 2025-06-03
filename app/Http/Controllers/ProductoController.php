<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\ProductosExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = $request->buscar;

        $productos = Producto::with('categoria')
            ->when($busqueda, function ($query, $busqueda) {
                $query->where('nombre', 'like', "%{$busqueda}%")
                      ->orWhere('codigo_producto', 'like', "%{$busqueda}%");
            })
            ->paginate(10)
            ->appends(['buscar' => $busqueda]);

        return view($this->vistaPorRol('productos.index'), compact('productos', 'busqueda'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view($this->vistaPorRol('productos.create'), compact('categorias'));
    }

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

        Producto::create($request->only([
            'codigo_producto',
            'nombre',
            'descripcion',
            'categoria_id',
            'precio_unitario',
            'stock_minimo',
            'estado'
        ]));

        return redirect()->route($this->rutaPorRol('productos.index'))
            ->with('success', 'Producto creado correctamente.');
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        return view($this->vistaPorRol('productos.edit'), compact('producto', 'categorias'));
    }

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

        $producto->update($request->only([
            'codigo_producto',
            'nombre',
            'descripcion',
            'categoria_id',
            'precio_unitario',
            'stock_minimo',
            'estado'
        ]));

        return redirect()->route($this->rutaPorRol('productos.index'))
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $producto->delete();

        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }

    public function exportExcel()
    {
        return Excel::download(new ProductosExport, 'productos.xlsx');
    }

    public function exportPDF()
    {
        $productos = Producto::with('categoria')->get();
        $pdf = Pdf::loadView('exports.productos_pdf', compact('productos'));
        return $pdf->download('productos.pdf');
    }

    /**
     * Devuelve la ruta correcta según el rol.
     */
    private function rutaPorRol($base)
    {
        if (Auth::user()->hasRole('admin')) {
            return 'admin.' . $base;
        } elseif (Auth::user()->hasRole('bodeguero')) {
            return 'bodeguero.' . $base;
        } else {
            return 'bodega.' . $base;
        }
    }

    /**
     * Devuelve la vista correcta según el rol.
     */
    private function vistaPorRol($base)
    {
        if (Auth::user()->hasRole('admin')) {
            return $base;
        } elseif (Auth::user()->hasRole('bodeguero')) {
            return 'bodeguero.' . $base;
        } else {
            return 'bodega.' . $base;
        }
    }
}
