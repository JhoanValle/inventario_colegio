<?php

namespace App\Models;
use App\Models\Equipo;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $fillable = [
    'equipo_id',
    'area',
    'responsable',
    'fecha_prestamo',
    'fecha_devolucion',
    'estado',
    'observacion'
];

public function equipo()
{
    return $this->belongsTo(Equipo::class);
}
}
