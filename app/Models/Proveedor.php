<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Equipo;

class Proveedor extends Model
{
    protected $table = 'proveedores'; 
    protected $fillable = [
        'nombre',
        'telefono',
        'email',
        'direccion',
        'estado'
    ];

    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }
}