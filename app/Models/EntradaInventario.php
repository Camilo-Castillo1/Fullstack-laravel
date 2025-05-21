<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Lote;
use App\Models\User; // Asumiendo que usas el modelo User

class EntradaInventario extends Model
{
    use HasFactory;

    protected $table = 'entradas_inventario';

    protected $fillable = [
        'lote_id',
        'usuario_id',
        'cantidad',
        'motivo',
        'fecha_movimiento',
    ];

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
