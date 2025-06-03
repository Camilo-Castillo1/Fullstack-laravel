<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductosExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Retorna todos los productos con sus categorías.
     */
    public function collection()
    {
        return Producto::with('categoria')->get();
    }

    /**
     * Define los encabezados de las columnas.
     */
    public function headings(): array
    {
        return [
            'ID',
            'Código',
            'Nombre',
            'Categoría',
            'Precio Unitario',
            'Stock Mínimo',
            'Estado',
        ];
    }

    /**
     * Define cómo se deben mapear los datos por fila.
     */
    public function map($producto): array
    {
        return [
            $producto->id,
            $producto->codigo_producto,
            $producto->nombre,
            $producto->categoria->nombre ?? 'Sin categoría',
            number_format($producto->precio_unitario, 2),
            $producto->stock_minimo,
            ucfirst($producto->estado),
        ];
    }
}
