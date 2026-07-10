<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Equipo;

class Categoria extends Model
{
    protected $fillable = ['nombre', 'descripcion'];

    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }
}