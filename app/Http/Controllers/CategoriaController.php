<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Helpers\BrowserHelper;

class CategoriaController extends Controller
{
    public function index(): View
    {
        $categorias = Categoria::orderBy('nombre', 'asc')->get();

        return view('categorias.index', compact('categorias'));
    }

    public function create(): View
    {
        return view('categorias.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => [
                'required',
                'unique:categorias,nombre',
                'regex:/^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/'
            ],
            'descripcion' => [
                'nullable',
                'regex:/^[A-ZÁÉÍÓÚÑa-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s.,-]*$/'
            ]
        ]);

        $categoria = Categoria::create([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
        ]);

        Movimiento::create([
            'equipo_id' => null,
            'user_id' => Auth::id(),
            'modulo' => 'Categorías',
            'accion' => 'Crear',
            'descripcion' => 'Se creó la categoría: ' . $categoria->nombre,
            'ip' => $request->ip(),
            'navegador' => BrowserHelper::name($request->userAgent()),
        ]);

        return redirect()->route('categorias.index')
            ->with('success', '✅ Categoría creada correctamente');
    }

    public function edit(int $id): View
    {
        $categoria = Categoria::findOrFail($id);

        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $categoria = Categoria::findOrFail($id);

        $request->validate([
            'nombre' => [
                'required',
                'unique:categorias,nombre,' . $id,
                'regex:/^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/'
            ],
            'descripcion' => [
                'nullable',
                'regex:/^[A-ZÁÉÍÓÚÑa-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s.,-]*$/'
            ]
        ]);

        $categoria->update([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
        ]);

        Movimiento::create([
            'equipo_id' => null,
            'user_id' => Auth::id(),
            'modulo' => 'Categorías',
            'accion' => 'Editar',
            'descripcion' => 'Se actualizó la categoría: ' . $categoria->nombre,
            'ip' => $request->ip(),
            'navegador' => BrowserHelper::name($request->userAgent()),
        ]);

        return redirect()->route('categorias.index')
            ->with('success', '✅ Categoría actualizada correctamente');
    }

    public function destroy(int $id): RedirectResponse
    {
        $categoria = Categoria::findOrFail($id);

        if ($categoria->equipos()->count() > 0) {
            return redirect()->route('categorias.index')
                ->with('error', '⚠ No se puede eliminar la categoría porque tiene equipos asociados.');
        }

        Movimiento::create([
            'equipo_id' => null,
            'user_id' => Auth::id(),
            'modulo' => 'Categorías',
            'accion' => 'Eliminar',
            'descripcion' => 'Se eliminó la categoría: ' . $categoria->nombre,
            'ip' => request()->ip(),
            'navegador' => BrowserHelper::name(request()->userAgent()),
        ]);

        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('success', '🗑 Categoría eliminada correctamente');
    }
}