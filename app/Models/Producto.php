<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;
use App\Models\Lote;// Asegúrate de que la ruta sea correcta
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

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function lotes()
    {
        return $this->hasMany(Lote::class, 'producto_id');
    }
}
