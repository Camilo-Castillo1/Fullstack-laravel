<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use App\Models\AlertaVencimiento;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class Lote extends Model
{
    use HasFactory;

    protected $table = 'lotes';

    protected $fillable = [
        'codigo_lote',
        'producto_id',
        'cantidad',
        'fecha_ingreso',
        'fecha_vencimiento',
        'estado'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function alertas()
    {
        return $this->hasMany(AlertaVencimiento::class, 'lote_id');
    }
    public function ubicaciones()
    {
        return $this->belongsToMany(
            \App\Models\UbicacionAlmacen::class,
            'lote_ubicacion',
            'id_lote',
            'id_ubicacion'
            )->withPivot('cantidad')->withTimestamps();
    }
    public function scopePorCodigo($query, $codigo)
    {
        return $query->where('codigo_lote', 'like', "%{$codigo}%");
    }

    public function scopePorProducto($query, $productoId)
    {
        return $query->where('producto_id', $productoId);
    }

    public function generarAlertaSiAplica()
{
    if ($this->fecha_ingreso && $this->fecha_vencimiento) {
        $ingreso = Carbon::parse($this->fecha_ingreso);
        $vencimiento = Carbon::parse($this->fecha_vencimiento);
        $dias = $ingreso->diffInDays($vencimiento, false);

        // Elimina todas las alertas anteriores de este lote (fecha vencimiento vieja)
        AlertaVencimiento::where('lote_id', $this->id)->delete();

        // Crea nueva alerta solo si la diferencia es menor o igual a 10 días
        if ($dias <= 10 && $dias >= 0) {
            AlertaVencimiento::create([
                'lote_id' => $this->id,
                'fecha_vencimiento' => $this->fecha_vencimiento,
                'fecha_alerta_generada' => now(),
                'estado' => 'pendiente',
            ]);
        }
    }
}
}
