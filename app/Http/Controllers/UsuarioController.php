<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\BrowserHelper;

class UsuarioController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $usuarios = User::where('id', '!=', $userId)->get();

        return view('usuarios.index', compact('usuarios'));
    }

    public function updateRol(Request $request, int $id)
    {
        $request->validate([
            'rol' => 'required|in:administrador,mantenimiento,directiva',
        ]);

        $usuario = User::findOrFail($id);

        $rolAnterior = $usuario->rol;

        $usuario->rol = $request->rol;
        $usuario->save();

        Movimiento::create([
            'equipo_id' => null,
            'user_id' => Auth::id(),
            'modulo' => 'Usuarios',
            'accion' => 'ROL',
            'descripcion' =>
                'Cambio de rol de ' .
                $usuario->name .
                ' de ' .
                $rolAnterior .
                ' a ' .
                $request->rol,
            'ip' => $request->ip(),
            'navegador' => BrowserHelper::name($request->userAgent()),
        ]);

        return back()->with(
            'success',
            'El rol de ' . $usuario->name . ' ha sido actualizado a ' . $request->rol
        );
    }
}