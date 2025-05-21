<?php

namespace App\Http\Controllers;

use App\Models\SalidaInventario;
use App\Models\Lote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalidaInventarioController extends Controller
{
    public function index()
    {
        $salidas = SalidaInventario::with(['lote.producto', 'usuario'])
            ->orderBy('fecha_movimiento', 'desc')
            ->get();

        return view('salidas.index', compact('salidas'));
    }

    public function create()
    {
        $lotes = Lote::with('producto')->get();
        return view('salidas.create', compact('lotes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lote_id'  => 'required|exists:lotes,id',
            'cantidad' => 'required|integer|min:1',
            'motivo'   => 'nullable|string|max:255',
        ]);

        $lote = Lote::findOrFail($request->lote_id);

        if ($lote->cantidad < $request->cantidad) {
            return back()->withErrors(['cantidad' => 'Stock insuficiente para esta salida.'])->withInput();
        }

        $lote->cantidad -= $request->cantidad;
        $lote->save();

        SalidaInventario::create([
            'lote_id' => $request->lote_id,
            'usuario_id' => Auth::user()->getKey(),
            'cantidad' => $request->cantidad,
            'motivo' => $request->motivo,
            'fecha_movimiento' => now(),
        ]);

        return redirect()->route('admin.salidas.index')->with('success', 'Salida registrada y stock actualizado.');
    }

    public function edit($id)
    {
        $salida = SalidaInventario::findOrFail($id);
        $lotes = Lote::with('producto')->get();

        return view('salidas.edit', compact('salida', 'lotes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'lote_id'  => 'required|exists:lotes,id',
            'cantidad' => 'required|integer|min:1',
            'motivo'   => 'nullable|string|max:255',
        ]);

        $salida = SalidaInventario::findOrFail($id);

        // Revertir stock anterior
        $loteAnterior = Lote::findOrFail($salida->lote_id);
        $loteAnterior->cantidad += $salida->cantidad;
        $loteAnterior->save();

        // Verificar nuevo stock disponible
        $loteNuevo = Lote::findOrFail($request->lote_id);
        if ($loteNuevo->cantidad < $request->cantidad) {
            return back()->withErrors(['cantidad' => 'Stock insuficiente en el nuevo lote.'])->withInput();
        }

        // Descontar nuevo stock
        $loteNuevo->cantidad -= $request->cantidad;
        $loteNuevo->save();

        $salida->update([
            'lote_id' => $request->lote_id,
            'cantidad' => $request->cantidad,
            'motivo' => $request->motivo,
            'fecha_movimiento' => now(),
        ]);

        return redirect()->route('admin.salidas.index')->with('success', 'Salida actualizada y stock ajustado.');
    }

    public function destroy($id)
    {
        $salida = SalidaInventario::findOrFail($id);

        $lote = $salida->lote;
        $lote->cantidad += $salida->cantidad;
        $lote->save();

        $salida->delete();

        return redirect()->route('admin.salidas.index')->with('success', 'Salida eliminada y stock restaurado.');
    }
}
