<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use App\Models\Movimiento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Helpers\BrowserHelper;

class ConfiguracionController extends Controller
{
    
    public function index(Request $request): View
    {
        $config = Configuracion::firstOrNew(['id' => 1]);

        return view('configuracion.index', [
            'config' => $config,
        ]);
    }

    
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre_institucion' => ['required', 'string', 'max:255'],
            'ruc'                => ['nullable', 'string', 'max:20'],
            'direccion'          => ['nullable', 'string', 'max:255'],
            'telefono'           => ['nullable', 'string', 'max:20'],
            'email'              => ['nullable', 'email', 'max:255'],
            'director'           => ['nullable', 'string', 'max:255'],
            'tipo_institucion'   => ['nullable', 'string', 'max:100'],
            'anio_fundacion'     => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
        ]);

        $configuracion = Configuracion::updateOrCreate(
            ['id' => 1],
            $request->only([
                'nombre_institucion',
                'ruc',
                'direccion',
                'telefono',
                'email',
                'director',
                'tipo_institucion',
                'anio_fundacion',
            ])
        );

        Movimiento::create([
            'equipo_id' => null,
            'user_id' => Auth::id(),
            'modulo' => 'Configuración',
            'accion' => 'Editar',
            'descripcion' => 'Se actualizó la configuración institucional: ' . $configuracion->nombre_institucion,
            'ip' => $request->ip(),
            'navegador' => BrowserHelper::name($request->userAgent()),
        ]);

        return Redirect::route('configuracion.index')->with('status', 'config-updated');
    }
}