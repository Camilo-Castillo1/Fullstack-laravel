<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\LoteUbicacion;
use App\Models\UbicacionAlmacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoteUbicacionController extends Controller
{
    public function index()
    {
        $asignaciones = LoteUbicacion::with(['lote.producto', 'ubicacion.almacen'])->get();
        return view('lote_ubicacion.index', compact('asignaciones'));
    }

    public function create()
    {
        return view('lote_ubicacion.create', [
            'lotes' => Lote::with('producto')->get(),
            'ubicaciones' => UbicacionAlmacen::with('almacen')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_lote' => 'required|exists:lotes,id',
            'id_ubicacion' => 'required|exists:ubicaciones_almacenamiento,id',
            'cantidad' => 'required|integer|min:0',
        ]);

        LoteUbicacion::create($request->only('id_lote', 'id_ubicacion', 'cantidad'));

        return redirect()->route('admin.lote-ubicacion.index')->with('success', 'Asignación creada correctamente.');
    }

    public function edit($id_lote, $id_ubicacion)
    {
        $asignacion = LoteUbicacion::where('id_lote', $id_lote)
            ->where('id_ubicacion', $id_ubicacion)
            ->firstOrFail();

        $lotes = Lote::with('producto')->get();
        $ubicaciones = UbicacionAlmacen::with('almacen')->get();

        return view('lote_ubicacion.edit', compact('asignacion', 'lotes', 'ubicaciones'));
    }

    public function update(Request $request, $id_lote, $id_ubicacion)
    {
        $request->validate([
            'id_lote' => 'required|exists:lotes,id',
            'id_ubicacion' => 'required|exists:ubicaciones_almacenamiento,id',
            'cantidad' => 'required|integer|min:0',
        ]);

        // Eliminar el registro anterior
        DB::table('lote_ubicacion')
            ->where('id_lote', $id_lote)
            ->where('id_ubicacion', $id_ubicacion)
            ->delete();

        // Insertar la nueva asignación con los valores actualizados
        LoteUbicacion::create([
            'id_lote' => $request->id_lote,
            'id_ubicacion' => $request->id_ubicacion,
            'cantidad' => $request->cantidad,
        ]);

        return redirect()->route('admin.lote-ubicacion.index')->with('success', 'Asignación actualizada correctamente.');
    }

    public function destroy($id_lote, $id_ubicacion)
    {
        LoteUbicacion::where('id_lote', $id_lote)
            ->where('id_ubicacion', $id_ubicacion)
            ->delete();

        return redirect()->route('admin.lote-ubicacion.index')->with('success', 'Asignación eliminada correctamente.');
    }
}
