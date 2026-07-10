<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Helpers\BrowserHelper;

class EquipoController extends Controller
{
    public function index(Request $request)
    {
        $query = Equipo::with(['categoria', 'proveedor']);

        if ($request->filled('codigo_patrimonial')) {
            $query->where('codigo_patrimonial', 'like', '%' . strtoupper($request->codigo_patrimonial) . '%');
        }

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('proveedor_id')) {
            $query->where('proveedor_id', $request->proveedor_id);
        }

        if ($request->filled('anio_ingreso')) {
            $query->where('anio_ingreso', $request->anio_ingreso);
        }

        $equipos = $query->orderBy('nombre', 'asc')->paginate(20);

        return view('equipos.index', compact('equipos'));
    }

    public function create()
    {
        return view('equipos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo_patrimonial' => ['required', 'min:11', 'max:20', 'unique:equipos,codigo_patrimonial', 'regex:/^[A-Z0-9]+$/'],
            'nombre' => ['required', 'regex:/^[A-ZÁÉÍÓÚÑa-záéíóúñ0-9\s\-]+$/u', 'max:255'],
            'categoria_id' => ['nullable', 'exists:categorias,id'],
            'estado' => ['required', 'in:Operativo,En mantenimiento,Necesita Reparacion,Malogrado,Perdido,Inactivo'],
            'ubicacion' => ['required', 'max:255'],
            'proveedor_id' => ['nullable', 'exists:proveedores,id'],
            'anio_ingreso' => ['required', 'integer', 'min:2000', 'max:2100'],
        ]);

        $equipo = Equipo::create([
            'codigo_patrimonial' => strtoupper($request->codigo_patrimonial),
            'nombre' => $request->nombre,
            'categoria_id' => $request->categoria_id,
            'estado' => $request->estado,
            'ubicacion' => $request->ubicacion,
            'proveedor_id' => $request->proveedor_id,
            'anio_ingreso' => $request->anio_ingreso,
        ]);

        Movimiento::create([
            'equipo_id' => $equipo->id,
            'user_id' => Auth::id(),
            'modulo' => 'Equipos',
            'accion' => 'CREAR',
            'descripcion' => 'Se registró el equipo "' . $equipo->nombre . '"',
            'ip' => $request->ip(),
            'navegador' => BrowserHelper::name($request->userAgent()),
        ]);

        return redirect()->route('equipos.index')
            ->with('success', 'Equipo registrado correctamente');
    }

    public function edit(int $id)
    {
        $equipo = Equipo::findOrFail($id);

        return view('equipos.edit', compact('equipo'));
    }

    public function update(Request $request, int $id)
    {
        $equipo = Equipo::findOrFail($id);

        $estadoAnterior = $equipo->estado;

        $request->validate([
            'codigo_patrimonial' => ['required', 'min:11', 'max:20', 'unique:equipos,codigo_patrimonial,' . $id, 'regex:/^[A-Z0-9]+$/'],
            'nombre' => ['required', 'regex:/^[A-ZÁÉÍÓÚÑa-záéíóúñ0-9\s\-]+$/u', 'max:255'],
            'estado' => ['required', 'in:Operativo,En mantenimiento,Necesita Reparacion,Malogrado,Perdido,Inactivo'],
            'ubicacion' => ['required', 'max:255'],
            'anio_ingreso' => ['required', 'integer', 'min:2000', 'max:2100'],
        ]);

        $equipo->update([
            'codigo_patrimonial' => strtoupper($request->codigo_patrimonial),
            'nombre' => $request->nombre,
            'categoria_id' => $request->categoria_id,
            'estado' => $request->estado,
            'ubicacion' => $request->ubicacion,
            'proveedor_id' => $request->proveedor_id,
            'anio_ingreso' => $request->anio_ingreso,
        ]);

        $descripcion = 'Se actualizó el equipo';

        if ($estadoAnterior != $request->estado) {
            $descripcion = 'Estado cambiado de "' . $estadoAnterior . '" a "' . $request->estado . '"';
        }

        Movimiento::create([
            'equipo_id' => $equipo->id,
            'user_id' => Auth::id(),
            'modulo' => 'Equipos',
            'accion' => 'EDITAR',
            'descripcion' => $descripcion,
            'ip' => $request->ip(),
            'navegador' => BrowserHelper::name($request->userAgent()),
        ]);

        return redirect()->route('equipos.index')
            ->with('success', 'Equipo actualizado correctamente');
    }

    public function destroy(int $id)
    {
        return redirect()->route('equipos.index')
            ->with('error', 'No está permitido eliminar equipos del sistema');
    }

    public function exportarEquipos(Request $request)
    {
        $fecha = Carbon::parse($request->mes);

        $equipos = Equipo::whereYear('created_at', $fecha->year)
            ->whereMonth('created_at', $fecha->month)
            ->get();

        $pdf = Pdf::loadView('pdf.equipos', [
            'equipos' => $equipos,
            'mes' => $request->mes
        ]);

        return $pdf->stream('reporte_equipos.pdf');
    }

    public function exportarMovimientos(Request $request)
    {
        $fecha = Carbon::parse($request->mes);

        $movimientos = Movimiento::with('equipo')
            ->whereYear('created_at', $fecha->year)
            ->whereMonth('created_at', $fecha->month)
            ->get();

        $pdf = Pdf::loadView('pdf.movimientos', [
            'movimientos' => $movimientos,
            'mes' => $request->mes
        ]);

        return $pdf->stream('reporte_movimientos.pdf');
    }
}