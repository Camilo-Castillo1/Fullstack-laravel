<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'password',
        'telefono',
        'estado',
        'id_rol' // 👈 Asegúrate de incluir esto
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }
}
