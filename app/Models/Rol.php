<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $fillable = ['nombre', 'descripcion'];

    /**
     * Relación de muchos a muchos con Permisos.
     * Incluye el campo 'asignado_por' en la tabla pivote y timestamps.
     */
    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'roles_permisos', 'id_rol', 'id_permiso')
                    ->withPivot('asignado_por')
                    ->withTimestamps();
    }

    /**
     * Asigna un permiso a un rol sin duplicaciones y con el usuario que lo asignó.
     *
     * @param int $permiso_id ID del permiso a asignar.
     * @param int $usuario_id ID del usuario que asigna el permiso.
     * @return void
     */
    public function asignarPermiso($permiso_id, $usuario_id)
    {
        // Asegurar que no haya duplicados y que se registre 'asignado_por'
        $this->permisos()->syncWithoutDetaching([
            $permiso_id => ['asignado_por' => $usuario_id]
        ]);
    }
}
//bien