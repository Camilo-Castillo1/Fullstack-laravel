<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

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
        'id_rol'
    ];
//para ocultar el password
    protected $hidden = [
        'password'
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    /**
     * Mutador para encriptar automáticamente la contraseña.
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
