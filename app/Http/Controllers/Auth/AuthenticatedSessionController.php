<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

use App\Models\User;
use App\Models\Auditoria;
use App\Helpers\BrowserHelper;

class AuthenticatedSessionController extends Controller
{
    /**
     * Mostrar vista login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Iniciar sesión
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Autenticar usuario
        $request->authenticate();

        // Obtener usuario autenticado
        /** @var User $user */
        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | VERIFICAR CORREO ELECTRÓNICO
        |--------------------------------------------------------------------------
        */

        if (!$user->email_verified_at) {

            Auth::logout();

            return back()->withErrors([
                'email' => 'Debes verificar tu correo electrónico antes de iniciar sesión.'
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDAR SI TIENE ROL ASIGNADO
        |--------------------------------------------------------------------------
        */

        if (!$user->rol) {

            Auth::logout();

            return back()->withErrors([
                'email' => 'Tu cuenta aún no tiene permisos asignados por el administrador.'
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | REGENERAR SESIÓN
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();


        // REGISTRO DE AUDITORÍA LOGIN
        Auditoria::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'rol' => $user->rol,
            'accion' => 'LOGIN',
            'ip' => $request->ip(),
            'navegador' => BrowserHelper::name($request->userAgent()),
        ]);


        $rol = $user->rol;


        /*
        |--------------------------------------------------------------------------
        | ADMINISTRADOR Y DIRECTIVA
        |--------------------------------------------------------------------------
        */

        if ($rol == 'administrador' || $rol == 'directiva') {

            return redirect()->route('dashboard');
        }


        /*
        |--------------------------------------------------------------------------
        | MANTENIMIENTO
        |--------------------------------------------------------------------------
        */

        if ($rol == 'mantenimiento') {

            return redirect()->route('diagnosticos.index');
        }


        /*
        |--------------------------------------------------------------------------
        | REDIRECCIÓN POR DEFECTO
        |--------------------------------------------------------------------------
        */

        Auth::logout();

        return redirect('/login');
    }


    /**
     * Cerrar sesión
     */
    public function destroy(Request $request): RedirectResponse
    {

        // Obtener usuario antes de cerrar sesión
        $user = Auth::user();


        // REGISTRO DE AUDITORÍA LOGOUT
        Auditoria::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'rol' => $user->rol,
            'accion' => 'LOGOUT',
            'ip' => $request->ip(),
            'navegador' => BrowserHelper::name($request->userAgent()),
        ]);


        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}