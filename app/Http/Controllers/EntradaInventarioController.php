<?php

namespace App\Http\Controllers;

use App\Models\EntradaInventario;
use App\Models\Lote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntradaInventarioController extends Controller
{
    public function index()
    {
        $entradas = EntradaInventario::with(['lote.producto', 'usuario'])
            ->orderBy('fecha_movimiento', 'desc')
            ->get();

        return view($this->vistaPorRol('entradas.index'), compact('entradas'));
    }

    public function create()
    {
        session()->forget('usuario_id');
        $lotes = Lote::with('producto')->get();

        return view($this->vistaPorRol('entradas.create'), compact('lotes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lote_id'  => 'required|exists:lotes,id',
            'cantidad' => 'required|integer|min:1',
            'motivo'   => 'nullable|string|max:255',
        ]);

        $lote = Lote::findOrFail($request->lote_id);
        $lote->cantidad += $request->cantidad;
        $lote->save();

        EntradaInventario::create([
            'lote_id' => $request->lote_id,
            'usuario_id' => Auth::user()->getKey(),
            'cantidad' => $request->cantidad,
            'motivo' => $request->motivo,
            'fecha_movimiento' => now(),
        ]);

        return redirect()->route($this->rutaPorRol('entradas.index'))
            ->with('success', 'Entrada registrada y stock actualizado.');
    }

    public function edit($id)
    {
        $entrada = EntradaInventario::findOrFail($id);
        $lotes = Lote::with('producto')->get();

        return view($this->vistaPorRol('entradas.edit'), compact('entrada', 'lotes'));
    }

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

        $loteAnterior = Lote::findOrFail($loteAnteriorId);
        $loteAnterior->cantidad -= $cantidadAnterior;

        if ($loteAnterior->cantidad < 0) {
            return back()->withErrors(['cantidad' => 'La operación dejaría el lote anterior con stock negativo.'])->withInput();
        }

        $loteAnterior->save();

        $loteNuevo = Lote::findOrFail($request->lote_id);
        $loteNuevo->cantidad += $request->cantidad;
        $loteNuevo->save();

        $entrada->update([
            'lote_id' => $request->lote_id,
            'cantidad' => $request->cantidad,
            'motivo' => $request->motivo,
            'fecha_movimiento' => now(),
        ]);

        return redirect()->route($this->rutaPorRol('entradas.index'))
            ->with('success', 'Entrada actualizada y stock ajustado correctamente.');
    }

    public function destroy($id)
    {
        $entrada = EntradaInventario::findOrFail($id);
        $lote = $entrada->lote;
        $lote->cantidad -= $entrada->cantidad;

        if ($lote->cantidad < 0) {
            $lote->cantidad = 0;
        }

        $lote->save();
        $entrada->delete();

        return redirect()->route($this->rutaPorRol('entradas.index'))
            ->with('success', 'Entrada eliminada y stock ajustado correctamente.');
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
            return 'bodega.' . $base; // administrador de bodega u otros
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
