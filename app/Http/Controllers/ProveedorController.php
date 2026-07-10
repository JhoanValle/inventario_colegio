<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\BrowserHelper;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::orderBy('nombre', 'asc')->get();

        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => [
                'required',
                'unique:proveedores,nombre',
                'regex:/^[\pL\s]+$/u',
                'max:255'
            ],
            'telefono' => [
                'required',
                'regex:/^[0-9+\-\(\)\s]+$/'
            ],
            'email' => [
                'required',
                'email',
                'max:255'
            ],
            'direccion' => [
                'required',
                'max:255'
            ],
        ]);

        $proveedor = Proveedor::create([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'direccion' => $request->direccion,
            'estado' => 'activo',
        ]);

        Movimiento::create([
            'equipo_id' => null,
            'user_id' => Auth::id(),
            'modulo' => 'Proveedores',
            'accion' => 'Crear',
            'descripcion' => 'Se creó el proveedor: ' . $proveedor->nombre,
            'ip' => $request->ip(),
            'navegador' => BrowserHelper::name($request->userAgent()),
        ]);

        return redirect()->route('proveedores.index')
            ->with('success', '✅ Proveedor registrado correctamente.');
    }

    public function edit(int $id)
    {
        $proveedor = Proveedor::findOrFail($id);

        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, int $id)
    {
        $proveedor = Proveedor::findOrFail($id);

        $request->validate([
            'nombre' => [
                'required',
                'unique:proveedores,nombre,' . $id,
                'regex:/^[\pL\s]+$/u',
                'max:255'
            ],
            'telefono' => [
                'required',
                'regex:/^[0-9+\-\(\)\s]+$/'
            ],
            'email' => [
                'required',
                'email',
                'max:255'
            ],
            'direccion' => [
                'required',
                'max:255'
            ],
        ]);

        $proveedor->update([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'direccion' => $request->direccion,
        ]);

        Movimiento::create([
            'equipo_id' => null,
            'user_id' => Auth::id(),
            'modulo' => 'Proveedores',
            'accion' => 'Editar',
            'descripcion' => 'Se actualizó el proveedor: ' . $proveedor->nombre,
            'ip' => $request->ip(),
            'navegador' => BrowserHelper::name($request->userAgent()),
        ]);

        return redirect()->route('proveedores.index')
            ->with('success', '✅ Proveedor actualizado correctamente.');
    }

    public function toggleEstado(int $id)
    {
        $proveedor = Proveedor::findOrFail($id);

        $nuevoEstado = $proveedor->estado == 'activo' ? 'inactivo' : 'activo';

        $proveedor->estado = $nuevoEstado;
        $proveedor->save();

        Movimiento::create([
            'equipo_id' => null,
            'user_id' => Auth::id(),
            'modulo' => 'Proveedores',
            'accion' => 'Estado',
            'descripcion' => 'Se cambió el estado a ' . $nuevoEstado . ' del proveedor: ' . $proveedor->nombre,
            'ip' => request()->ip(),
            'navegador' => BrowserHelper::name(request()->userAgent()),
        ]);

        return redirect()->route('proveedores.index')
            ->with('success', '✅ Estado del proveedor actualizado.');
    }

    public function destroy(int $id)
    {
        $proveedor = Proveedor::findOrFail($id);

        Movimiento::create([
            'equipo_id' => null,
            'user_id' => Auth::id(),
            'modulo' => 'Proveedores',
            'accion' => 'Eliminar',
            'descripcion' => 'Se eliminó el proveedor: ' . $proveedor->nombre,
            'ip' => request()->ip(),
            'navegador' => BrowserHelper::name(request()->userAgent()),
        ]);

        $proveedor->delete();

        return redirect()->route('proveedores.index')
            ->with('success', '🗑 Proveedor eliminado correctamente.');
    }
}