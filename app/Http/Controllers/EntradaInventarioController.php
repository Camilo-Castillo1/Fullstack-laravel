<?php

namespace App\Http\Controllers;

use App\Models\EntradaInventario;
use App\Models\Lote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EntradaInventarioController extends Controller
{
    /**
     * Mostrar la lista de entradas de inventario.
     */
    public function index()
    {
        $entradas = EntradaInventario::with(['lote.producto', 'usuario'])
            ->orderBy('fecha_movimiento', 'desc')
            ->get();

        return view('entradas.index', compact('entradas'));
    }

    /**
     * Mostrar formulario para crear una nueva entrada.
     */
    public function create()
    {
        session()->forget('usuario_id');
        $lotes = Lote::with('producto')->get();
        return view('entradas.create', compact('lotes'));
    }

    /**
     * Guardar la nueva entrada en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lote_id'  => 'required|exists:lotes,id',
            'cantidad' => 'required|integer|min:1',
            'motivo'   => 'nullable|string|max:255',
        ]);

        $lote = Lote::findOrFail((int) $request->input('lote_id'));
        $lote->cantidad += (int) $request->input('cantidad');
        $lote->save();

        $entradaInventario = EntradaInventario::create([
            'lote_id' => $request->lote_id,
            'usuario_id' => Auth::user()->getKey(),
            'cantidad' => $request->cantidad,
            'motivo' => $request->motivo,
            'fecha_movimiento' => now(),
        ]);

        return redirect()->route('admin.entradas.index')
            ->with('success', 'Entrada registrada y stock actualizado.');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit($id)
    {
        $entrada = EntradaInventario::findOrFail($id);
        $lotes = Lote::with('producto')->get();
        return view('entradas.edit', compact('entrada', 'lotes'));
    }

    /**
     * Actualizar una entrada existente.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'lote_id'  => 'required|exists:lotes,id',
        'cantidad' => 'required|integer|min:1',
        'motivo'   => 'nullable|string|max:255',
    ]);

    $entrada = EntradaInventario::findOrFail($id);
    $cantidadAnterior = $entrada->cantidad;
    $loteAnteriorId = $entrada->lote_id;

    // Revertir la cantidad del lote anterior
    $loteAnterior = Lote::findOrFail($loteAnteriorId);
    $loteAnterior->cantidad -= $cantidadAnterior;

    // Validar que no quede negativo
    if ($loteAnterior->cantidad < 0) {
        return back()->withErrors(['cantidad' => 'La operación dejaría el lote anterior con stock negativo.'])->withInput();
    }

    $loteAnterior->save();

    // Sumar la nueva cantidad al lote nuevo
    $loteNuevo = Lote::findOrFail($request->lote_id);
    $loteNuevo->cantidad += $request->cantidad;
    $loteNuevo->save();

    // Actualizar la entrada
    $entrada->update([
        'lote_id' => $request->lote_id,
        'cantidad' => $request->cantidad,
        'motivo' => $request->motivo,
        'fecha_movimiento' => now(),
    ]);


    return redirect()->route('admin.entradas.index')
        ->with('success', 'Entrada actualizada y stock ajustado correctamente.');
}
    public function destroy($id)
{
    $entrada = EntradaInventario::findOrFail($id);

    // Revertir la cantidad al lote
    $lote = $entrada->lote;
    $lote->cantidad -= $entrada->cantidad;

    // Evita que el stock quede negativo
    if ($lote->cantidad < 0) {
        $lote->cantidad = 0;
    }

    $lote->save();

    $entrada->delete();

    return redirect()->route('admin.entradas.index')
        ->with('success', 'Entrada eliminada y stock ajustado correctamente.');
}

    }

