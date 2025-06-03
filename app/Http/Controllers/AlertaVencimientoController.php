<?php

namespace App\Http\Controllers;

use App\Models\AlertaVencimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlertaVencimientoController extends Controller
{
    /**
     * Muestra todas las alertas de vencimiento.
     */
    public function index()
    {
        $alertas = AlertaVencimiento::with('lote.producto')
            ->where('estado', 'pendiente')
            ->orderBy('fecha_alerta_generada', 'desc')
            ->get();

        if (Auth::user()->hasRole('admin')) {
            return view('alertavencimiento.index', compact('alertas'));
        }

        if (Auth::user()->hasRole('administrador de bodega')) {
            return view('bodega.alertas.index', compact('alertas'));
        }

        if (Auth::user()->hasRole('bodeguero')) {
            return view('bodeguero.alertas.index', compact('alertas'));
        }

        abort(403);
    }

    /**
     * Muestra el formulario para atender una alerta.
     */
    public function atender($id)
    {
        $alerta = AlertaVencimiento::with('lote.producto')->findOrFail($id);

        if (Auth::user()->hasRole('admin')) {
            return view('admin.alertas.atender', compact('alerta'));
        }

        if (Auth::user()->hasRole('administrador de bodega')) {
            return view('bodega.alertas.atender', compact('alerta'));
        }

        if (Auth::user()->hasRole('bodeguero')) {
            return view('bodeguero.alertas.atender', compact('alerta'));
        }

        abort(403);
    }

    /**
     * Marca una alerta como atendida.
     */
    public function resolver(Request $request, $id)
    {
        $request->validate([
            'observacion' => 'nullable|string|max:1000',
        ]);

        $alerta = AlertaVencimiento::findOrFail($id);

        $alerta->estado = 'atendida';
        $alerta->observacion = $request->input('observacion');
        $alerta->resuelta_por = Auth::user()->getKey();
        $alerta->fecha_resolucion = now();
        $alerta->save();

        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('admin.alertas.index')->with('success', 'Alerta marcada como atendida.');
        }

        if (Auth::user()->hasRole('administrador de bodega')) {
            return redirect()->route('bodega.alertas.index')->with('success', 'Alerta marcada como atendida.');
        }

        if (Auth::user()->hasRole('bodeguero')) {
            return redirect()->route('bodeguero.alertas.index')->with('success', 'Alerta marcada como atendida.');
        }

        abort(403);
    }

    /**
     * Vista solo consulta (admin).
     */
    public function show(AlertaVencimiento $alerta)
    {
        $alerta->load('lote.producto');

        if (Auth::user()->hasRole('admin')) {
            return view('alertavencimiento.show', compact('alerta'));
        }

        if (Auth::user()->hasRole('bodeguero')) {
            return view('bodeguero.alertas.show', compact('alerta'));
        }

        abort(403);
    }
}
