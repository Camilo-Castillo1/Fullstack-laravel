<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UbicacionAlmacen;

class Almacen extends Model
{
    protected $table = 'almacenes';

    protected $fillable = [
        'nombre',
        'ubicacion',
        'capacidad_maxima',
    ];

    // Relación: un almacén tiene muchas ubicaciones
    public function ubicaciones()
    {
        return $this->hasMany(UbicacionAlmacen::class, 'almacen_id');
    }
}
