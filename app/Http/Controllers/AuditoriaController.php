<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;

class AuditoriaController extends Controller
{
    public function index()
    {
        $auditorias = Auditoria::with('user')
            ->latest()
            ->paginate(10);

        return view('usuarios.auditorias.index', compact('auditorias'));
    }
}