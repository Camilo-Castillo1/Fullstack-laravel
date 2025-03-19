<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoteUbicacion extends Model
{
    use HasFactory;

    protected $table = 'lote_ubicacion'; // Nombre correcto de la tabla
    public $timestamps = false; // Desactiva `created_at` y `updated_at` si no están en la tabla
    public $incrementing = false; // Laravel no debe esperar una columna `id`
    protected $primaryKey = ['id_lote', 'id_ubicacion']; // Definir clave primaria compuesta

    protected $fillable = ['id_lote', 'id_ubicacion', 'cantidad'];

    // Relaciones
    public function lote()
    {
        return $this->belongsTo(Lote::class, 'id_lote');
    }

    public function ubicacion()
    {
        return $this->belongsTo(UbicacionAlmacen::class, 'id_ubicacion');
    }
}
