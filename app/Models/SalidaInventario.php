<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
use App\Models\Lote;

class SalidaInventario extends Model
{
    use HasFactory;

    protected $table = 'salidas_inventario';
    protected $fillable = ['lote_id', 'usuario_id', 'cantidad', 'motivo'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class, 'lote_id');
    }
}
