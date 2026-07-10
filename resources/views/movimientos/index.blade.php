@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">📊 Historial de Movimientos</h2>
        <p class="text-muted mb-0">
            Registro de actividades realizadas en el sistema
        </p>
    </div>

    <span class="badge bg-dark fs-6 px-3 py-2">
        Total: {{ $movimientos->total() }}
    </span>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-dark">
                <tr>
                    <th class="ps-4">Módulo</th>
                    <th>Acción</th>
                    <th>Descripción</th>
                    <th>Usuario</th>
                    <th>Navegador</th>
                    <th class="text-center">Fecha</th>
                </tr>
            </thead>

            <tbody>

                @forelse($movimientos as $m)

                <tr>

                    {{-- MÓDULO --}}
                    <td class="ps-4 fw-semibold">
                        {{ $m->modulo ?? 'General' }}
                    </td>

                    {{-- ACCIÓN --}}
                    <td>
                        @if($m->accion == 'Crear')
                            <span class="badge bg-primary">➕ Crear</span>

                        @elseif($m->accion == 'Editar')
                            <span class="badge bg-warning text-dark">✏️ Editar</span>

                        @elseif($m->accion == 'Eliminar')
                            <span class="badge bg-danger">🗑 Eliminar</span>

                        @else
                            <span class="badge bg-secondary">
                                {{ $m->accion }}
                            </span>
                        @endif
                    </td>

                    {{-- DESCRIPCIÓN --}}
                    <td style="max-width: 320px;">
                        <span class="text-muted">
                            {{ $m->descripcion ?? 'Sin descripción' }}
                        </span>
                    </td>

                    {{-- USUARIO --}}
                    <td>
                        {{ $m->user->name ?? 'Sistema' }}
                    </td>

                    {{-- NAVEGADOR --}}
                    <td class="text-muted">
                        {{ $m->navegador ?? '-' }}
                    </td>

                    {{-- FECHA --}}
                    <td class="text-center text-nowrap">
                        <div class="fw-semibold">
                            {{ optional($m->created_at)->format('d/m/Y') }}
                        </div>
                        <small class="text-muted">
                            {{ optional($m->created_at)->format('H:i') }}
                        </small>
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="text-muted">
                            <div class="fs-1 mb-3">📭</div>
                            <h5 class="fw-semibold">No hay movimientos registrados</h5>
                        </div>
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="d-flex justify-content-center mt-4">
    {{ $movimientos->links() }}
</div>

@endsection