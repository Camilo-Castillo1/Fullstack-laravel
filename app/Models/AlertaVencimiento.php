<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lote;

class AlertaVencimiento extends Model
{
    use HasFactory;

    protected $table = 'alertas_vencimiento';
    public $timestamps = false;//cambie
    protected $fillable = ['lote_id', 'fecha_vencimiento', 'estado'];

    public function lote()
    {
        return $this->belongsTo(Lote::class, 'lote_id');
    }
}

