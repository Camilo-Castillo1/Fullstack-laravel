<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;

    protected $table = 'permisos';
    protected $fillable = ['nombre', 'modulo', 'descripcion'];

    /**
     * Relación de muchos a muchos con Roles.
     * Se incluye el campo 'asignado_por' en la tabla pivote y timestamps.
     */
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'roles_permisos', 'id_permiso', 'id_rol')
                    ->withPivot('asignado_por')
                    ->withTimestamps();
    }
}
// bien
