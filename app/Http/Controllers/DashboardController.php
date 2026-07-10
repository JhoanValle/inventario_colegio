<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Prestamo;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | TOTAL DE EQUIPOS
        |--------------------------------------------------------------------------
        */

        $total = Equipo::count();

        /*
        |--------------------------------------------------------------------------
        | ESTADOS DE EQUIPOS
        |--------------------------------------------------------------------------
        */

        $operativos = Equipo::where(
            'estado',
            'Operativo'
        )->count();

        $reparacion = Equipo::where(
            'estado',
            'Necesita Reparacion'
        )->count();

        $mantenimiento = Equipo::where(
            'estado',
            'En mantenimiento'
        )->count();

        $malogrados = Equipo::where(
            'estado',
            'Malogrado'
        )->count();

        $perdidos = Equipo::where(
            'estado',
            'Perdido'
        )->count();

        $inactivos = Equipo::where(
            'estado',
            'Inactivo'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | EQUIPOS CON PROBLEMAS
        | SOLO:
        | - Necesita Reparacion
        | - En mantenimiento
        | - Malogrado
        |--------------------------------------------------------------------------
        */

        $problemas = $reparacion
                    + $mantenimiento
                    + $malogrados;

        /*
        |--------------------------------------------------------------------------
        | EQUIPOS PRESTADOS
        |--------------------------------------------------------------------------
        */

        $equiposPrestados = Prestamo::whereIn('estado', [

            'Prestado',
            'Retrasado'

        ])->count();

        /*
        |--------------------------------------------------------------------------
        | ÚLTIMOS EQUIPOS REGISTRADOS
        |--------------------------------------------------------------------------
        */

        $ultimos = Equipo::latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | PORCENTAJES
        |--------------------------------------------------------------------------
        */

        $porcentajeOperativos = $total > 0

            ? round(
                ($operativos * 100) / $total,
                1
            )

            : 0;

        $porcentajeProblemas = $total > 0

            ? round(
                ($problemas * 100) / $total,
                1
            )

            : 0;

        /*
        |--------------------------------------------------------------------------
        | ALERTAS
        |--------------------------------------------------------------------------
        */

        $retrasados = Prestamo::where(
            'estado',
            'Retrasado'
        )->count();

        $sinFecha = Prestamo::where(
                'estado',
                'Prestado'
            )
            ->whereNull('fecha_devolucion')
            ->count();

        $mantenimientoLargo = Equipo::where(
                'estado',
                'En mantenimiento'
            )
            ->where(
                'updated_at',
                '<',
                Carbon::now()->subDays(15)
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | RETORNAR VISTA
        |--------------------------------------------------------------------------
        */

        return view('dashboard', compact(

            'total',

            'operativos',

            'reparacion',

            'mantenimiento',

            'malogrados',

            'perdidos',

            'inactivos',

            'problemas',

            'equiposPrestados',

            'ultimos',

            'porcentajeOperativos',

            'porcentajeProblemas',

            'retrasados',

            'sinFecha',

            'mantenimientoLargo'
        ));
    }
}