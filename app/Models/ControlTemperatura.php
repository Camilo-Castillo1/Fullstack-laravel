<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Almacen;

class ControlTemperatura extends Model
{
    use HasFactory;

    protected $table = 'control_temperatura';
    protected $fillable = ['almacen_id', 'temperatura'];

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }
}
