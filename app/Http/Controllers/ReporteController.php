<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reporte;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ReporteController extends Controller
{
    // Formulario de creación (bodeguero)
    public function create()
    {
        return view('bodeguero.reportes.create');
    }

    // Guardar nuevo reporte
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
        ]);

        Reporte::create([
            'user_id' => Auth::user()->getKey(),
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('bodeguero.reportes.create')->with('success', 'Reporte enviado correctamente.');
    }

    // Mostrar lista de reportes en una vista web
public function index()
{
    $reportes = Reporte::with('usuario')->latest()->get();
    return view('reportes.pdf', compact('reportes')); // Usa una vista web distinta
}

// Descargar todos los reportes en PDF
public function descargarPDF()
{
    $reportes = Reporte::with('usuario')->latest()->get();
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reportes.pdf', compact('reportes'));
    return $pdf->download('reportes-generales.pdf');
}


    // Ver PDF individual
public function verPDF($id)
{
    $reporte = Reporte::with('usuario')->findOrFail($id);
    $pdf = Pdf::loadView('reportes.ver-pdf', compact('reporte'));
    return $pdf->stream("reporte-{$id}.pdf");
}


}
