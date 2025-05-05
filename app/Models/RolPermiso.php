<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolPermiso extends Model
{
    use HasFactory;

    protected $table = 'roles_permisos';
    public $incrementing = false; 
    protected $primaryKey = null;
    protected $fillable = ['id_rol', 'id_permiso', 'asignado_por'];
    // asignado_por para crear o actualizar el registro
//funciones  para consultas más limpias
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    public function permiso()
    {
        return $this->belongsTo(Permiso::class, 'id_permiso');
    }
}
