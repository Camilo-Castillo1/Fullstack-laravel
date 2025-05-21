<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles, Notifiable;

    protected $table = 'users'; // <- Singular

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'password',
        'telefono',
        'estado',
        'ultimo_acceso',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'correo_verified_at' => 'datetime',
        'ultimo_acceso' => 'datetime',
        'fecha_creacion' => 'datetime',
        'fecha_actualizacion' => 'datetime',
    ];

    public function getAuthIdentifierName()
    {
        return 'correo';
    }

    public function username()
    {
        return 'id';
    }

}
