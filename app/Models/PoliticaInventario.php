<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UbicacionAlmacen;
use App\Models\Categoria;
use App\Models\Almacen;

class PoliticaInventario extends Model
{
    use HasFactory;

    protected $table = 'politicas_inventario';

    protected $fillable = [
        'nombre',
        'tipo',
        'aplicable_a',
        'valor',
        'fecha_implementacion',
        'tipo_producto', // campo para el tipo de producto
        'ubicacion_id',
        'categoria_id',
        'almacen_id'
    ];

    public function ubicacion()
    {
        return $this->belongsTo(UbicacionAlmacen::class, 'ubicacion_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }
}
