<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoliticaInventario extends Model
{
    use HasFactory;

    protected $table = 'politicas_inventario';

    protected $fillable = [
        'nombre',
        'tipo',
        'aplicable_a',
        'fecha_implementacion', // ✅ Agregar este campo
        'ubicacion_id',
        'categoria_id',
        'almacen_id'
    ];
}
