<?php

namespace App\Http\Controllers;

use App\Models\AlertaVencimiento;
use Illuminate\Http\Request;

class AlertaVencimientoController extends Controller
{
    /**
     * Muestra todas las alertas de vencimiento, ordenadas por fecha de alerta.
     */
    public function index()
    {
        $alertas = AlertaVencimiento::with('lote.producto')
            ->orderBy('fecha_alerta_generada', 'desc')
            ->get();

        return view('alertavencimiento.index', compact('alertas'));
    }

    /**
     * Muestra el detalle de una alerta específica.
     */
    public function show(AlertaVencimiento $alerta)
    {
        $alerta->load('lote.producto');
        return view('alertavencimiento.show', compact('alerta'));
    }
}
