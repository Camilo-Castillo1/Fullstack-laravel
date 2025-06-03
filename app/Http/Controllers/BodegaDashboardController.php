<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\EntradaInventario;
use App\Models\SalidaInventario;
use App\Models\AlertaVencimiento;
use App\Models\Lote;
use App\Models\UbicacionAlmacen;
use App\Models\Almacen;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BodegaDashboardController extends Controller
{
    public function index()
    {
        // Cálculo manual del stock total sumando entradas y restando salidas
        $lotes = Lote::pluck('id');

        $totalEntradas = DB::table('entradas_inventario')
            ->whereIn('lote_id', $lotes)
            ->sum('cantidad');

        $totalSalidas = DB::table('salidas_inventario')
            ->whereIn('lote_id', $lotes)
            ->sum('cantidad');

        $stockTotal = $totalEntradas - $totalSalidas;

        // Entradas y salidas del día actual (corregido a fecha_movimiento)
        $entradasHoy = EntradaInventario::whereDate('fecha_movimiento', today())->count();
        $salidasHoy = SalidaInventario::whereDate('fecha_movimiento', today())->count();

        // Alertas activas
        $alertasActivas = AlertaVencimiento::where('estado', 'pendiente')->count();


        // Lotes y ubicaciones
        $lotesTotal = Lote::count();
        $ubicacionesTotal = UbicacionAlmacen::count();

        // Entradas vs salidas últimos 7 días
        $dias = collect();
        $entradasSemana = collect();
        $salidasSemana = collect();

        for ($i = 6; $i >= 0; $i--) {
            $fecha = Carbon::today()->subDays($i);
            $dias->push($fecha->format('D')); // Lunes, Martes, etc.
            $entradasSemana->push(
                EntradaInventario::whereDate('fecha_movimiento', $fecha)->count()
            );
            $salidasSemana->push(
                SalidaInventario::whereDate('fecha_movimiento', $fecha)->count()
            );
        }

        return view('bodeguero.dashboard', compact(
            'stockTotal',
            'entradasHoy',
            'salidasHoy',
            'alertasActivas',
            'lotesTotal',
            'ubicacionesTotal',
            'dias',
            'entradasSemana',
            'salidasSemana'
        ));
    }
}
