<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin|administrador de bodega|bodeguero');
    }

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

        if (auth()->user()->hasRole('admin')) {
            return view('lotes.index', compact('lotes', 'busqueda', 'estado', 'producto_id', 'productos'));
        }

        if (auth()->user()->hasRole('administrador de bodega')) {
            return view('bodega.lotes.index', compact('lotes', 'busqueda', 'estado', 'producto_id', 'productos'));
        }

        // Vista exclusiva para bodeguero
        return view('bodeguero.lotes.index', compact('lotes', 'busqueda', 'estado', 'producto_id', 'productos'));
    }

    public function create()
    {
        if (auth()->user()->hasRole('bodeguero')) {
            abort(403, 'No tienes permiso para crear lotes.');
        }

        $productos = Producto::all();

        if (auth()->user()->hasRole('admin')) {
            return view('lotes.create', compact('productos'));
        }

        return view('bodega.lotes.create', compact('productos'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->hasRole('bodeguero')) {
            abort(403, 'No tienes permiso para registrar lotes.');
        }

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

        return $this->redireccionSegunRol('Lote creado correctamente.');
    }

    public function edit(Lote $lote)
    {
        if (auth()->user()->hasRole('bodeguero')) {
            abort(403, 'No tienes permiso para editar lotes.');
        }

        $productos = Producto::all();

        if (auth()->user()->hasRole('admin')) {
            return view('lotes.edit', compact('lote', 'productos'));
        }

        return view('bodega.lotes.edit', compact('lote', 'productos'));
    }

    public function update(Request $request, Lote $lote)
    {
        if (auth()->user()->hasRole('bodeguero')) {
            abort(403, 'No tienes permiso para actualizar lotes.');
        }

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

        return $this->redireccionSegunRol('Lote actualizado correctamente.');
    }

    public function destroy(Lote $lote)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'No tienes permiso para eliminar lotes.');
        }

        $lote->delete();
        return redirect()->route('admin.lotes.index')->with('success', 'Lote eliminado.');
    }

    /**
     * Redirige según el rol del usuario actual.
     */
    private function redireccionSegunRol(string $mensaje)
    {
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.lotes.index')->with('success', $mensaje);
        }

        if (Auth::user()->hasRole('administrador de bodega')) {
            return redirect()->route('bodega.lotes.index')->with('success', $mensaje);
        }

        return redirect()->route('bodeguero.lotes.index')->with('success', $mensaje);
    }
}
