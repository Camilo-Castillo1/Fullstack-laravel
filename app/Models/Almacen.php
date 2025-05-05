<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ControlTemperatura;
// Asegura que el modelo ControlTemperatura esté disponible
class Almacen extends Model
{
    use HasFactory;

    protected $table = 'almacenes';
    protected $fillable = ['nombre', 'ubicacion', 'capacidad_maxima'];

    public function controlTemperatura()
    {
        return $this->hasMany(ControlTemperatura::class, 'almacen_id');
    }
}
