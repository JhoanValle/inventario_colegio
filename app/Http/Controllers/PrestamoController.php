<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\Equipo;
use App\Models\Movimiento;
use Illuminate\Support\Facades\Auth;
use App\Helpers\BrowserHelper;

class PrestamoController extends Controller
{
    public function index(Request $request)
    {
        Prestamo::where('estado', 'Prestado')
            ->whereNotNull('fecha_devolucion')
            ->where('fecha_devolucion', '<', now()->toDateString())
            ->update([
                'estado' => 'Retrasado'
            ]);

        $query = Prestamo::with('equipo');

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $prestamos = $query->latest()->get();

        $total = Prestamo::count();
        $prestados = Prestamo::where('estado', 'Prestado')->count();
        $devueltos = Prestamo::where('estado', 'Devuelto')->count();
        $retrasados = Prestamo::where('estado', 'Retrasado')->count();

        return view('prestamos.index', compact(
            'prestamos',
            'total',
            'prestados',
            'devueltos',
            'retrasados'
        ));
    }

    public function create()
    {
        $equipos = Equipo::where('estado', 'Operativo')
            ->whereDoesntHave('prestamos', function ($query) {
                $query->whereIn('estado', [
                    'Prestado',
                    'Retrasado'
                ]);
            })
            ->orderBy('nombre', 'asc')
            ->get();

        return view('prestamos.create', compact('equipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'equipo_id' => ['required', 'exists:equipos,id'],
            'area' => ['required', 'regex:/^[A-ZÁÉÍÓÚÑa-záéíóúñ0-9\s\-]+$/u', 'max:255'],
            'responsable' => ['required', 'regex:/^[A-ZÁÉÍÓÚÑa-záéíóúñ\s]+$/u', 'max:255'],
            'fecha_prestamo' => ['required', 'date'],
            'fecha_devolucion' => ['nullable', 'date', 'after_or_equal:fecha_prestamo'],
            'estado' => ['required', 'in:Prestado,Devuelto,Retrasado']
        ]);

        $equipo = Equipo::findOrFail($request->equipo_id);

        // Solo equipos operativos pueden prestarse
        if ($equipo->estado !== 'Operativo') {
            return redirect()->route('prestamos.create')
                ->with('error', '⚠️ El equipo no está disponible para préstamo.');
        }

        $existe = Prestamo::where('equipo_id', $request->equipo_id)
            ->whereIn('estado', [
                'Prestado',
                'Retrasado'
            ])
            ->exists();

        if ($existe) {
            return redirect()->route('prestamos.create')
                ->with('error', '⚠️ El equipo ya está prestado.');
        }

        $prestamo = Prestamo::create([
            'equipo_id' => $request->equipo_id,
            'area' => $request->area,
            'responsable' => $request->responsable,
            'fecha_prestamo' => $request->fecha_prestamo,
            'fecha_devolucion' => $request->fecha_devolucion,
            'estado' => $request->estado,
        ]);

        Movimiento::create([
            'equipo_id' => $prestamo->equipo_id,
            'user_id' => Auth::id(),
            'modulo' => 'Préstamos',
            'accion' => 'PRESTAMO',
            'descripcion' => 'Equipo prestado a ' . $prestamo->responsable . ' (' . $prestamo->area . ')',
            'ip' => $request->ip(),
            'navegador' => BrowserHelper::name($request->userAgent()),
        ]);

        return redirect()->route('prestamos.index')
            ->with('success', '✅ Préstamo registrado correctamente');
    }

    public function update(Request $request, int $id)
    {
        $prestamo = Prestamo::findOrFail($id);

        if ($prestamo->estado === 'Devuelto') {
            return back()->with('error', '⚠️ Ya fue devuelto.');
        }

        $prestamo->update([
            'estado' => 'Devuelto',
            'fecha_devolucion' => now()->toDateString()
        ]);

        Movimiento::create([
            'equipo_id' => $prestamo->equipo_id,
            'user_id' => Auth::id(),
            'modulo' => 'Préstamos',
            'accion' => 'DEVUELTO',
            'descripcion' => 'Equipo devuelto por ' . $prestamo->responsable,
            'ip' => request()->ip(),
            'navegador' => BrowserHelper::name(request()->userAgent()),
        ]);

        return redirect()->route('prestamos.index')
            ->with('success', '✔ Equipo devuelto correctamente.');
    }
}