@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">📦 Gestión de Préstamos</h3>
        <p class="text-muted mb-0">
            Control y seguimiento de préstamos de equipos
        </p>
    </div>

    @if(auth()->user()->rol == 'administrador')

        <a href="{{ route('prestamos.create') }}"
           class="btn btn-primary shadow-sm rounded-pill px-4">

            ➕ Nuevo Préstamo

        </a>

    @endif

</div>

{{-- TARJETAS RESUMEN --}}
<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body text-center">
                <div class="fs-5 mb-2">📦</div>
                <h6 class="text-muted">Total</h6>
                <h2 class="fw-bold">{{ $total }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-4 border-warning">
            <div class="card-body text-center">
                <div class="fs-5 mb-2">🟡</div>
                <h6 class="text-muted">Prestados</h6>
                <h2 class="fw-bold text-warning">{{ $prestados }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-4 border-success">
            <div class="card-body text-center">
                <div class="fs-5 mb-2">🟢</div>
                <h6 class="text-muted">Devueltos</h6>
                <h2 class="fw-bold text-success">{{ $devueltos }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-4 border-danger">
            <div class="card-body text-center">
                <div class="fs-5 mb-2">🔴</div>
                <h6 class="text-muted">Retrasados</h6>
                <h2 class="fw-bold text-danger">{{ $retrasados }}</h2>
            </div>
        </div>
    </div>

</div>

{{-- FILTROS --}}
<div class="d-flex flex-wrap gap-2 mb-4">

    <a href="{{ route('prestamos.index') }}"
       class="btn btn-outline-secondary rounded-pill btn-sm">
        🔄 Todos
    </a>

    <a href="{{ route('prestamos.index', ['estado' => 'Prestado']) }}"
       class="btn btn-outline-warning rounded-pill btn-sm">
        🟡 Prestados
    </a>

    <a href="{{ route('prestamos.index', ['estado' => 'Devuelto']) }}"
       class="btn btn-outline-success rounded-pill btn-sm">
        🟢 Devueltos
    </a>

    <a href="{{ route('prestamos.index', ['estado' => 'Retrasado']) }}"
       class="btn btn-outline-danger rounded-pill btn-sm">
        🔴 Retrasados
    </a>

</div>

{{-- ALERTAS --}}
@if(session('success'))

    <div class="alert alert-success shadow-sm border-0 rounded-3">
        {{ session('success') }}
    </div>

@endif

@if(session('error'))

    <div class="alert alert-danger shadow-sm border-0 rounded-3">
        {{ session('error') }}
    </div>

@endif

{{-- TABLA --}}
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-dark">

                <tr>

                    <th class="ps-4">Equipo</th>
                    <th>Código</th>
                    <th>Área</th>
                    <th>Responsable</th>
                    <th>F. Préstamo</th>
                    <th>F. Devolución</th>
                    <th>Estado</th>

                    @if(auth()->user()->rol == 'administrador')
                        <th class="text-center">Acción</th>
                    @endif

                </tr>

            </thead>

            <tbody>

                @forelse($prestamos as $p)

                <tr>

                    {{-- EQUIPO --}}
                    <td class="ps-4">

                        <div class="fw-semibold text-dark">

                            {{ $p->equipo->nombre ?? 'N/A' }}

                        </div>

                    </td>

                    {{-- CÓDIGO --}}
                    <td>

                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2 shadow-sm">

                            {{ $p->equipo->codigo_patrimonial ?? 'Sin Código' }}

                        </span>

                    </td>

                    {{-- ÁREA --}}
                    <td>

                        <span class="fw-medium text-secondary">

                            {{ $p->area }}

                        </span>

                    </td>

                    {{-- RESPONSABLE --}}
                    <td>

                        <div class="d-flex align-items-center gap-2">

                            <div class="bg-primary rounded-circle"
                                 style="width:10px;height:10px;">
                            </div>

                            <span class="fw-semibold">

                                {{ $p->responsable }}

                            </span>

                        </div>

                    </td>

                    {{-- FECHA PRÉSTAMO --}}
                    <td class="text-nowrap">

                        <div class="fw-semibold">

                            {{ \Carbon\Carbon::parse($p->fecha_prestamo)->format('d/m/Y') }}

                        </div>

                    </td>

                    {{-- FECHA DEVOLUCIÓN --}}
                    <td class="text-nowrap">

                        @if($p->fecha_devolucion)

                            <div class="fw-semibold">

                                {{ \Carbon\Carbon::parse($p->fecha_devolucion)->format('d/m/Y') }}

                            </div>

                        @else

                            <span class="text-muted">-</span>

                        @endif

                        @if($p->estado == 'Retrasado' && $p->fecha_devolucion)

                            <small class="text-danger fw-semibold d-block mt-1">

                                ⏰
                                {{ \Carbon\Carbon::parse($p->fecha_devolucion)
                                    ->startOfDay()
                                    ->diffInDays(now()->startOfDay()) }}

                                días de retraso

                            </small>

                        @endif

                    </td>

                    {{-- ESTADO --}}
                    <td>

                        @if($p->estado == 'Prestado')

                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2 shadow-sm">

                                🟡 Prestado

                            </span>

                        @elseif($p->estado == 'Devuelto')

                            <span class="badge bg-success rounded-pill px-3 py-2 shadow-sm">

                                🟢 Devuelto

                            </span>

                        @elseif($p->estado == 'Retrasado')

                            <span class="badge bg-danger rounded-pill px-3 py-2 shadow-sm">

                                🔴 Retrasado

                            </span>

                        @endif

                    </td>

                    {{-- ACCIONES --}}
                    @if(auth()->user()->rol == 'administrador')

                    <td class="text-center">

                        @if($p->estado == 'Prestado' || $p->estado == 'Retrasado')

                            <form action="{{ route('prestamos.update', $p->id) }}"
                                  method="POST">

                                @csrf
                                @method('PUT')

                                <button class="btn btn-success btn-sm rounded-pill px-3 shadow-sm">

                                    ✔ Marcar Devuelto

                                </button>

                            </form>

                        @else

                            <span class="text-muted small">

                                Sin acciones

                            </span>

                        @endif

                    </td>

                    @endif

                </tr>

                @empty

                <tr>

                    <td colspan="8" class="text-center py-5">

                        <div class="text-muted">

                            <div class="fs-1 mb-3">
                                📭
                            </div>

                            <h5 class="fw-semibold">

                                No hay préstamos registrados

                            </h5>

                            <p class="mb-0">

                                Los préstamos aparecerán aquí automáticamente.

                            </p>

                        </div>

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection