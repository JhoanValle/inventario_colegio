<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Proveedor;
use App\Models\Categoria; 
class Equipo extends Model
{
    protected $fillable = [
        'nombre',
        'categoria_id',
        'estado',
        'ubicacion',
        'proveedor_id',
        'codigo_patrimonial',
        'anio_ingreso'
    ];
    
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    public function diagnosticos()
    {
        return $this->hasMany(Diagnostico::class);
    }

    public function prestamos() {
    return $this->hasMany(Prestamo::class);
    }

}
