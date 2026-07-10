<?php

namespace App\Http\Controllers;

use App\Models\Diagnostico;
use Barryvdh\DomPDF\Facade\Pdf;

class DiagnosticoController extends Controller
{
    public function index()
    {
        $diagnosticos = Diagnostico::with('equipo')
            ->latest()
            ->get();

        return view('diagnosticos.index', compact('diagnosticos'));
    }

    public function pdf()
    {
        $diagnosticos = Diagnostico::with('equipo')
            ->latest()
            ->get();

        $pdf = Pdf::loadView('diagnosticos.pdf', compact('diagnosticos'));
        
        return $pdf->stream('reporte_diagnosticos.pdf');
    }
}