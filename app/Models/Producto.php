<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;
use App\Models\Lote;
use Illuminate\Support\Facades\DB;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'codigo_producto',
        'nombre',
        'descripcion',
        'categoria_id',
        'precio_unitario',
        'stock_minimo',
        'estado',
    ];

    // Relación con categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    // Relación con lotes
    public function lotes()
    {
        return $this->hasMany(Lote::class, 'producto_id');
    }

    // Stock en tiempo real
    public function getStockAttribute()
{
    // IDs de los lotes que pertenecen a este producto
    $lotes = DB::table('lotes')
        ->where('producto_id', $this->id)
        ->pluck('id');

    $entradas = DB::table('entradas_inventario')
        ->whereIn('lote_id', $lotes)
        ->sum('cantidad');

    $salidas = DB::table('salidas_inventario')
        ->whereIn('lote_id', $lotes)
        ->sum('cantidad');

    return $entradas - $salidas;
}

}
