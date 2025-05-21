<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoteUbicacion extends Model
{
    use HasFactory;

    protected $table = 'lote_ubicacion';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = ['id_lote', 'id_ubicacion', 'cantidad'];

    public function lote()
    {
        return $this->belongsTo(Lote::class, 'id_lote');
    }

    public function ubicacion()
    {
        return $this->belongsTo(UbicacionAlmacen::class, 'id_ubicacion');
    }
}
