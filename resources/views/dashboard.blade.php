@extends('layouts.app')

@section('content')

<h3 class="mb-4">📊 Dashboard</h3>


@if($problemas == 0)
    <div class="alert alert-success shadow-sm">
        🎉 Todos los equipos están operativos (100%)
    </div>
@else
    <div class="alert alert-danger shadow-sm">
        ⚠️ {{ $problemas }} equipos requieren atención ({{ $porcentajeProblemas }}%)
    </div>
@endif

<div class="row g-4">

   
    <div class="col-md-3">
        <div class="card bg-primary text-white p-3 shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">Total Equipos</h6>
                    <h2 class="mb-0 fw-bold">{{ $total }}</h2>
                </div>
                <i class="bi bi-pc-display fs-1 opacity-50"></i>
            </div>
        </div>
    </div>

    
    <div class="col-md-3">
        <div class="card bg-success text-white p-3 shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">Disponibles / Operativos</h6>
                    <h2 class="mb-0 fw-bold">{{ $operativos }}</h2>
                </div>
                <i class="bi bi-check-circle fs-1 opacity-50"></i>
            </div>
        </div>
    </div>

    
    <div class="col-md-3">
        <div class="card bg-info text-white p-3 shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6>Equipos Fuera (Prestados)</h6>
                    <h2 class="mb-0 fw-bold">{{ $equiposPrestados }}</h2>
                </div>
                <i class="bi bi-box-arrow-up fs-1 opacity-50"></i>
            </div>
        </div>
    </div>

 
    <div class="col-md-3">
        <div class="card bg-info text-white p-3 shadow-sm border-0" style="filter: hue-rotate(45deg);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6>Reparación</h6>
                    <h2 class="mb-0 fw-bold">{{ $reparacion }}</h2>
                </div>
                <i class="bi bi-tools fs-1 opacity-50"></i>
            </div>
        </div>
    </div>

    
    <div class="col-md-3">
        <div class="card bg-warning text-dark p-3 shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6>Mantenimiento</h6>
                    <h2 class="mb-0 fw-bold">{{ $mantenimiento }}</h2>
                </div>
                <i class="bi bi-gear-wide-connected fs-1 opacity-50"></i>
            </div>
        </div>
    </div>

   
    <div class="col-md-3">
        <div class="card bg-danger text-white p-3 shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6>Malogrados</h6>
                    <h2 class="mb-0 fw-bold">{{ $malogrados }}</h2>
                </div>
                <i class="bi bi-x-circle fs-1 opacity-50"></i>
            </div>
        </div>
    </div>

    
    <div class="col-md-3">
        <div class="card bg-secondary text-white p-3 shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6>Perdidos</h6>
                    <h2 class="mb-0 fw-bold">{{ $perdidos }}</h2>
                </div>
                <i class="bi bi-search fs-1 opacity-50"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-light text-dark p-3 shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6>Inactivos</h6>
                    <h2 class="mb-0 fw-bold">{{ $inactivos }}</h2>
                </div>
                    <i class="bi bi-pause-circle fs-1 opacity-50"></i>
            </div>
        </div>
    </div>

    
    <div class="col-md-3">
        <div class="card bg-dark text-white p-3 shadow-sm border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6>Con Problemas</h6>
                    <h2 class="mb-0 fw-bold">{{ $problemas }}</h2>
                </div>
                <i class="bi bi-exclamation-triangle fs-1 opacity-50"></i>
            </div>
        </div>
    </div>

</div>


<div class="row mt-4">

    
    <div class="col-md-4">
        <div class="card p-3 shadow-sm">
            <h6 class="text-center">Distribución de Estado</h6>
            <canvas id="graficoCircular" style="max-height:220px;"></canvas>
        </div>
    </div>

    
    <div class="col-md-4">
        <div class="card p-3 shadow-sm">
            <h6 class="text-center">Comparación de Cantidades</h6>
            <canvas id="graficoBarras" style="max-height:220px;"></canvas>
        </div>
    </div>

    
    <div class="col-md-4">
        @php
            $color = 'success';
            if($porcentajeProblemas > 50) { $color = 'danger'; } 
            elseif($porcentajeProblemas > 20) { $color = 'warning'; }
        @endphp

        <div class="card border-{{ $color }} p-3 text-center shadow-sm">
            @if($porcentajeProblemas == 0)
                <h5 class="text-success">✔ Estado Óptimo</h5>
            @elseif($porcentajeProblemas <= 20)
                <h5 class="text-success">✔ La mayoría de equipos están operativos ({{ $porcentajeOperativos }}%)</h5>
            @elseif($porcentajeProblemas <= 50)
                <h5 class="text-warning">⚠️ Algunos equipos requieren atención ({{ $porcentajeProblemas }}%)</h5>
            @else
                <h5 class="text-danger">🚨 Muchos equipos presentan fallas ({{ $porcentajeProblemas }}%)</h5>
            @endif
            
            <hr>
            <p class="mb-0">Hay <strong>{{ $retrasados }}</strong> préstamos con retraso.</p>
        </div>
    </div>

</div>


<div class="card mt-4 p-3 shadow-sm">
    <h6>Últimos equipos registrados</h6>
    <table class="table table-sm mt-2">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ultimos as $e)
            <tr>
                <td>{{ $e->nombre }}</td>
                <td>
                    <span class="badge 
                        @if($e->estado == 'Operativo') bg-success
                        @elseif($e->estado == 'Malogrado') bg-danger
                        @elseif($e->estado == 'Perdido') bg-dark
                        @elseif($e->estado == 'Necesita Reparacion') bg-info
                        @else bg-warning
                        @endif
                    ">
                        {{ $e->estado }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const datos = [
        Number("{{ $operativos ?? 0 }}"),
        Number("{{ $equiposPrestados ?? 0 }}"),
        Number("{{ $reparacion ?? 0 }}"),
        Number("{{ $mantenimiento ?? 0 }}"),
        Number("{{ $malogrados ?? 0 }}"),
        Number("{{ $perdidos ?? 0 }}"),
        Number("{{ $inactivos ?? 0 }}")
    ];

    const labels = [
        'Operativos',
        'Prestados',
        'Reparación',
        'Mantenimiento',
        'Malogrados',
        'Perdidos',
        'Inactivos'
    ];

    const colores = [
        '#198754', 
        '#0dcaf0', 
        '#00cfd5', 
        '#ffc107', 
        '#dc3545', 
        '#6c757d',
        '#adb5bd'
    ];

    
    new Chart(document.getElementById('graficoCircular'), {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: datos,
                backgroundColor: colores
            }]
        }
    });

   
    new Chart(document.getElementById('graficoBarras'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Cantidad',
                data: datos,
                backgroundColor: colores
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });
});
</script>

@endsection