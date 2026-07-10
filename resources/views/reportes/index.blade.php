@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-1">
            📊 Módulo de Reportes
        </h3>

        <small class="text-muted">
            Generación de reportes del sistema de inventario
        </small>

    </div>

</div>

<div class="row g-4">

    <!-- REPORTE EQUIPOS -->

    <div class="col-lg-6">

        <div class="card border-0 shadow-sm rounded-4 h-100">

            <div class="card-body p-4 d-flex flex-column">

                <div class="d-flex align-items-center mb-3">

                    <div class="me-3 fs-2">
                        📦
                    </div>

                    <div>

                        <h5 class="fw-bold mb-1">
                            Reporte de Equipos
                        </h5>

                        <small class="text-muted">
                            Exporta el inventario mensual de equipos
                        </small>

                    </div>

                </div>

                <form action="{{ route('equipos.exportar') }}"
                      method="GET"
                      target="_blank"
                      class="mt-3">

                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Seleccionar Mes
                        </label>

                        <input type="month"
                               name="mes"
                               class="form-control form-control-lg rounded-3"
                               required>

                    </div>

                    <button type="submit"
                            class="btn btn-danger w-100 rounded-3 py-2 fw-semibold">

                        <i class="bi bi-file-earmark-pdf"></i>
                        Generar Reporte

                    </button>

                </form>

            </div>

        </div>

    </div>

    <!-- REPORTE MOVIMIENTOS -->

    <div class="col-lg-6">

        <div class="card border-0 shadow-sm rounded-4 h-100">

            <div class="card-body p-4 d-flex flex-column">

                <div class="d-flex align-items-center mb-3">

                    <div class="me-3 fs-2">
                        🔄
                    </div>

                    <div>

                        <h5 class="fw-bold mb-1">
                            Reporte de Movimientos
                        </h5>

                        <small class="text-muted">
                            Exporta movimientos y registros realizados
                        </small>

                    </div>

                </div>

                <form action="{{ route('movimientos.exportar') }}"
                      method="GET"
                      target="_blank"
                      class="mt-3">

                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Seleccionar Mes
                        </label>

                        <input type="month"
                               name="mes"
                               class="form-control form-control-lg rounded-3"
                               required>

                    </div>

                    <button type="submit"
                            class="btn btn-success w-100 rounded-3 py-2 fw-semibold">

                        <i class="bi bi-file-earmark-excel"></i>
                        Generar Reporte

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<!-- PANEL EXTRA -->

<div class="row mt-4">

    <div class="col-12">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-4 text-center">

                <h5 class="fw-bold mb-2">
                    📈 Centro de Reportes
                </h5>

                <p class="text-muted mb-0">
                    Desde este módulo puedes generar reportes PDF y consultar
                    información histórica del inventario institucional.
                </p>

            </div>

        </div>

    </div>

</div>

@endsection