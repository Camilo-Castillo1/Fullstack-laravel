<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Producto;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = $request->input('buscar');
        $estado = $request->input('estado');
        $producto_id = $request->input('producto_id');

        $lotes = Lote::with('producto')
            ->when($busqueda, fn($q) => $q->porCodigo($busqueda))
            ->when($estado, fn($q) => $q->where('estado', $estado))
            ->when($producto_id, fn($q) => $q->porProducto($producto_id))
            ->orderBy('fecha_ingreso', 'asc')
            ->get();

        $productos = Producto::all();

        return view('lotes.index', compact('lotes', 'busqueda', 'estado', 'producto_id', 'productos'));
    }

    public function create()
    {
        $productos = Producto::all();
        return view('lotes.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo_lote' => 'required|string|max:50',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'fecha_ingreso' => 'required|date',
            'fecha_vencimiento' => 'nullable|date|after_or_equal:fecha_ingreso',
            'estado' => 'required|in:disponible,agotado,vencido',
        ]);

        $existe = Lote::where('producto_id', $request->producto_id)
                      ->where('codigo_lote', $request->codigo_lote)
                      ->exists();

        if ($existe) {
            return back()->withErrors(['codigo_lote' => 'El código ya existe para este producto.'])->withInput();
        }

        $lote = Lote::create($request->all());
        $lote->generarAlertaSiAplica();

        return redirect()->route('admin.lotes.index')->with('success', 'Lote creado correctamente.');
    }

    public function edit(Lote $lote)
    {
        $productos = Producto::all();
        return view('lotes.edit', compact('lote', 'productos'));
    }

    public function update(Request $request, Lote $lote)
    {
        $request->validate([
            'codigo_lote' => 'required|string|max:50',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'fecha_ingreso' => 'required|date',
            'fecha_vencimiento' => 'nullable|date|after_or_equal:fecha_ingreso',
            'estado' => 'required|in:disponible,agotado,vencido',
        ]);

        $existe = Lote::where('producto_id', $request->producto_id)
                      ->where('codigo_lote', $request->codigo_lote)
                      ->where('id', '!=', $lote->id)
                      ->exists();

        if ($existe) {
            return back()->withErrors(['codigo_lote' => 'El código ya está registrado para este producto.'])->withInput();
        }

        $lote->update($request->all());
        $lote->generarAlertaSiAplica();

        return redirect()->route('admin.lotes.index')->with('success', 'Lote actualizado correctamente.');
    }

    public function destroy(Lote $lote)
    {
        $lote->delete();
        return redirect()->route('admin.lotes.index')->with('success', 'Lote eliminado.');
    }
}
