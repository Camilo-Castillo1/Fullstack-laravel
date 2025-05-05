<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Almacen;// se usa el modelo Almacen


class UbicacionAlmacen extends Model
{
    use HasFactory;

    protected $table = 'ubicaciones_almacenamiento';
    protected $fillable = ['almacen_id', 'codigo_ubicacion', 'tipo_almacenamiento', 'capacidad_maxima'];

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }
}

