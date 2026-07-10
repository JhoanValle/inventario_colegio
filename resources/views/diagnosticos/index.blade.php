@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="mb-1">📋 Historial de Diagnósticos IA</h3>
        <small class="text-muted">
            Registro de diagnósticos generados por el asistente inteligente
        </small>
    </div>

    <div class="d-flex gap-2">

        <a href="{{ route('chatbot.index') }}"
           class="btn btn-secondary">
            ⬅ Volver
        </a>

        <a href="{{ route('diagnosticos.pdf') }}"
           class="btn btn-danger"
           target="_blank">
            📄 Vista previa PDF
        </a>

    </div>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-header bg-white">

        <h5 class="mb-0">
            Historial de diagnósticos
        </h5>

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>
                    <th>Equipo / Codigo</th>
                    <th>Problema Detectado</th>
                    <th>Riesgo</th>
                    <th>Fecha</th>
                    <th width="120">Detalle</th>
                </tr>

            </thead>

            <tbody>

                @forelse($diagnosticos as $d)

                    <tr>

                        <td>

                            <div class="fw-bold">

                                {{ $d->equipo->nombre ?? 'Sin nombre' }}

                        </div>

                        <small class="text-muted">

                            Código:
                            {{ $d->equipo->codigo_patrimonial ?? 'N/A' }}

                        </small>

                        </td>

                        <td>

                            {{ \Illuminate\Support\Str::limit($d->problema, 70) }}

                        </td>

                        <td>

                            @if($d->riesgo == 'Alto')

                                <span class="badge bg-danger">
                                    🔴 Alto
                                </span>

                            @elseif($d->riesgo == 'Medio')

                                <span class="badge bg-warning text-dark">
                                    🟡 Medio
                                </span>

                            @else

                                <span class="badge bg-success">
                                    🟢 Bajo
                                </span>

                            @endif

                        </td>

                        <td>

                            {{ $d->created_at->format('d/m/Y H:i') }}

                        </td>

                        <td>

                            <button
                                class="btn btn-primary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#diagnostico{{ $d->id }}">

                                👁 Ver

                            </button>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="text-center py-4 text-muted">

                            No existen diagnósticos registrados.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

{{-- MODALES --}}

@foreach($diagnosticos as $d)

<div class="modal fade"
     id="diagnostico{{ $d->id }}"
     tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-scrollable">

        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-primary text-white">

                <h5 class="modal-title">
                    🤖 Diagnóstico IA
                </h5>

                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                {{-- INFORMACIÓN DEL EQUIPO --}}
                <div class="mb-4">

                    <h6 class="fw-bold text-dark">
                        🖥 Información del Equipo
                    </h6>

                    <div class="border rounded p-3 bg-light">

                        <p class="mb-2">

                            <strong>Código:</strong>

                            {{ $d->equipo->codigo_patrimonial ?? 'N/A' }}

                        </p>

                        <p class="mb-2">

                            <strong>Nombre:</strong>

                            {{ $d->equipo->nombre ?? 'N/A' }}

                        </p>

                        @if(isset($d->equipo->marca))
                        <p class="mb-2">

                            <strong>Marca:</strong>

                            {{ $d->equipo->marca }}

                        </p>
                        @endif

                        @if(isset($d->equipo->modelo))
                        <p class="mb-0">

                            <strong>Modelo:</strong>

                            {{ $d->equipo->modelo }}

                        </p>
                        @endif

                    </div>

                </div>

                {{-- PROBLEMA --}}
                <div class="mb-4">

                    <h6 class="fw-bold text-danger">
                        ❗ Problema Detectado
                    </h6>

                    <p class="mb-0">

                        {{ $d->problema }}

                    </p>

                </div>

                {{-- CAUSAS --}}
                <div class="mb-4">

                    <h6 class="fw-bold text-warning">
                        🔍 Posibles Causas
                    </h6>

                    <div class="border rounded p-3 bg-light"
                         style="white-space: pre-line;">

                        {{ $d->causa }}

                    </div>

                </div>

                {{-- SOLUCIONES --}}
                <div class="mb-4">

                    <h6 class="fw-bold text-primary">
                        🛠 Soluciones Recomendadas
                    </h6>

                    <div class="border rounded p-3 bg-light"
                         style="white-space: pre-line;">

                        {{ $d->solucion }}

                    </div>

                </div>

                {{-- RECOMENDACIONES --}}
                <div class="mb-4">

                    <h6 class="fw-bold text-success">
                        💡 Recomendaciones
                    </h6>

                    <div class="border rounded p-3 bg-light"
                         style="white-space: pre-line;">

                        {{ $d->recomendacion }}

                    </div>

                </div>

                {{-- RIESGO --}}
                <div>

                    <h6 class="fw-bold">
                        ⚠ Nivel de Riesgo
                    </h6>

                    @if($d->riesgo == 'Alto')

                        <span class="badge bg-danger fs-6">
                            Alto
                        </span>

                    @elseif($d->riesgo == 'Medio')

                        <span class="badge bg-warning text-dark fs-6">
                            Medio
                        </span>

                    @else

                        <span class="badge bg-success fs-6">
                            Bajo
                        </span>

                    @endif

                </div>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Cerrar

                </button>

            </div>

        </div>

    </div>

</div>

@endforeach

@endsection