<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use App\Models\AlertaVencimiento;

class Lote extends Model
{
    use HasFactory;

    protected $table = 'lotes';
    protected $fillable = [
        'codigo_lote', 'producto_id', 'cantidad',
        'fecha_ingreso', 'fecha_vencimiento', 'estado'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function alertas()
    {
        return $this->hasMany(AlertaVencimiento::class, 'lote_id');
    }
}
