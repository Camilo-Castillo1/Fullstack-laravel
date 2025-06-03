<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reporte extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'titulo', 'descripcion'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
