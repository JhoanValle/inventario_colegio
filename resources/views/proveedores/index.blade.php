@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                🚚 Gestión de Proveedores
            </h3>

            <p class="text-muted mb-0">
                Administra los proveedores registrados en el sistema
            </p>

        </div>

        <a href="{{ route('proveedores.create') }}"
           class="btn btn-primary shadow-sm">

            ➕ Nuevo Proveedor

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
                                Proveedor
                            </th>

                            <th class="text-center py-3">
                                Teléfono
                            </th>

                            <th class="text-center py-3">
                                Correo Electrónico
                            </th>

                            <th class="text-center py-3">
                                Estado
                            </th>

                            <th class="text-center py-3">
                                Acciones
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($proveedores as $p)

                            <tr>

                                {{-- NOMBRE --}}
                                <td class="px-4">

                                    <div class="fw-semibold">

                                        {{ $p->nombre }}

                                    </div>

                                </td>

                                {{-- TELEFONO --}}
                                <td class="text-center">

                                    @if($p->telefono)

                                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2">

                                            📞 {{ $p->telefono }}

                                        </span>

                                    @else

                                        <span class="text-muted">

                                            No registrado

                                        </span>

                                    @endif

                                </td>

                                {{-- EMAIL --}}
                                <td class="text-center">

                                    @if($p->email)

                                        <span class="text-primary fw-medium">

                                            {{ $p->email }}

                                        </span>

                                    @else

                                        <span class="text-muted">

                                            No registrado

                                        </span>

                                    @endif

                                </td>

                                {{-- ESTADO --}}
                                <td class="text-center">

                                    @if($p->estado == 'activo')

                                        <span class="badge bg-success rounded-pill px-3 py-2">

                                            ✅ Activo

                                        </span>

                                    @else

                                        <span class="badge bg-danger rounded-pill px-3 py-2">

                                            🚫 Inactivo

                                        </span>

                                    @endif

                                </td>

                                {{-- ACCIONES --}}
                                <td>

                                    <div class="d-flex justify-content-center gap-2">

                                        {{-- EDITAR --}}
                                        <a href="{{ route('proveedores.edit', $p->id) }}"
                                           class="btn btn-warning btn-sm px-3">

                                            ✏️ Editar

                                        </a>

                                        {{-- ACTIVAR / INHABILITAR --}}
                                        <form action="{{ route('proveedores.estado', $p->id) }}"
                                              method="POST">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="btn btn-secondary btn-sm px-3">

                                                @if($p->estado == 'activo')

                                                    🚫 Inhabilitar

                                                @else

                                                    ✅ Activar

                                                @endif

                                            </button>

                                        </form>


                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center py-5">

                                    <div class="text-muted">

                                        <h5 class="mb-2">
                                            📭 No hay proveedores registrados
                                        </h5>

                                        <p class="mb-0">
                                            Comienza agregando un nuevo proveedor al sistema.
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