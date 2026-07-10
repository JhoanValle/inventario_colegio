<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Diagnostico extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipo_id',
        'problema',
        'causa',
        'solucion',
        'recomendacion',
        'riesgo'
    ];

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }
}