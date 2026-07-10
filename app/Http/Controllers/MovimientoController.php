<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimiento;

class MovimientoController extends Controller
{
    public function index()
    {
        
        $movimientos = Movimiento::with(['equipo', 'user'])
            ->latest()
            ->paginate(20);

        return view('movimientos.index', compact('movimientos'));
    }
}