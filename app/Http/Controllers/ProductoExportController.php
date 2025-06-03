<?php

namespace App\Http\Controllers;

use App\Exports\ProductosExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // solo si usarás PDF
use App\Models\Producto;

class ProductoExportController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(new ProductosExport, 'productos.xlsx');
    }

    public function exportPDF()
    {
        $productos = Producto::with('categoria')->get();
        $pdf = Pdf::loadView('bodega.productos.export_pdf', compact('productos'));

        return $pdf->download('productos.pdf');
    }
}
