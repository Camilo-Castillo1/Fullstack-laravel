<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogUsuario extends Model
{
    use HasFactory;

    protected $table = 'log_usuarios';
    protected $fillable = ['id_usuario', 'tipo_evento', 'campo_modificado', 'valor_anterior', 'valor_nuevo'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
//bien