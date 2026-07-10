@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                📁 Gestión de Categorías
            </h3>

            <p class="text-muted mb-0">
                Administra las categorías de equipos registradas en el sistema
            </p>
        </div>

        <a href="{{ route('categorias.create') }}"
           class="btn btn-primary shadow-sm">

            ➕ Nueva Categoría

        </a>

    </div>

    {{-- ALERTAS --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- CARD --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-4 py-3">
                                Nombre
                            </th>

                            <th class="py-3 text-center">
                                Equipos Asociados
                            </th>

                            <th class="py-3 text-center">
                                Acciones
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($categorias as $categoria)

                            <tr>

                                {{-- NOMBRE --}}
                                <td class="px-4">

                                    <div class="fw-semibold">
                                        {{ $categoria->nombre }}
                                    </div>

                                </td>

                                {{-- EQUIPOS --}}
                                <td class="text-center">

                                    <span class="badge bg-primary rounded-pill px-3 py-2">

                                        {{ $categoria->equipos->count() }} Equipos

                                    </span>

                                </td>

                                {{-- ACCIONES --}}
                                <td>

                                    <div class="d-flex justify-content-center gap-2">

                                        {{-- EDITAR --}}
                                        <a href="{{ route('categorias.edit', $categoria->id) }}"
                                           class="btn btn-warning btn-sm px-3">

                                            ✏️ Editar

                                        </a>

                                        {{-- ELIMINAR --}}
                                        <form action="{{ route('categorias.destroy', $categoria->id) }}"
                                              method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-danger btn-sm px-3"
                                                    onclick="return confirm('⚠️ ¿Seguro que deseas eliminar esta categoría?')">

                                                🗑 Eliminar

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="3" class="text-center py-5">

                                    <div class="text-muted">

                                        <h5 class="mb-2">
                                            📭 No hay categorías registradas
                                        </h5>

                                        <p class="mb-0">
                                            Comienza agregando una nueva categoría al sistema.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection