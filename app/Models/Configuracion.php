<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    
    protected $table = 'configuracion';

    
    protected $fillable = [
        'nombre_institucion',
        'ruc',
        'direccion',
        'telefono',
        'email',
        'director',
        'tipo_institucion',
        'anio_fundacion',
    ];
}