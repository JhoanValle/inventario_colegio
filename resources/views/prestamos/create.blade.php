@extends('layouts.app')

@section('content')

<h3 class="mb-4">📦 Registrar Préstamo</h3>

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close">
        </button>
    </div>
@endif

<div class="card p-4 shadow-sm">

    <form action="{{ route('prestamos.store') }}" method="POST">
        @csrf

        {{-- EQUIPO --}}
        <div class="mb-3">

            <label class="form-label">
                Equipo
            </label>

            <select name="equipo_id"
                    class="form-control @error('equipo_id') is-invalid @enderror"
                    required>

                <option value="">
                    -- Seleccionar Equipo --
                </option>

                @foreach($equipos as $e)

                    @if(
                        $e->estado != 'Inactivo' &&
                        $e->estado != 'Perdido' &&
                        $e->estado != 'Malogrado'
                    )

                        <option value="{{ $e->id }}"
                            {{ old('equipo_id') == $e->id ? 'selected' : '' }}>

                            {{ $e->nombre }}
                            ({{ $e->codigo_patrimonial }})
                            - {{ $e->estado }}

                        </option>

                    @endif

                @endforeach

            </select>

            @error('equipo_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            <small class="text-muted">
                Solo se muestran equipos disponibles para préstamo.
            </small>

        </div>

        <div class="row">

            {{-- ÁREA --}}
            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Área / Destino
                </label>

                <input type="text"
                    name="area"
                    class="form-control"
                    value="{{ old('area') }}"
                    placeholder="Ej: Aula 1, Dirección"
                    required>

            </div>

            {{-- RESPONSABLE --}}
            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Responsable
                </label>

                <input type="text"
                    name="responsable"
                    class="form-control"
                    value="{{ old('responsable') }}"
                    placeholder="Nombre del docente"
                    required>

            </div>

        </div>

        <div class="row">

            {{-- FECHA PRESTAMO --}}
            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Fecha de Préstamo
                </label>

                <input type="date"
                    name="fecha_prestamo"
                    class="form-control"
                    value="{{ old('fecha_prestamo', date('Y-m-d')) }}"
                    required>

            </div>

            {{-- FECHA DEVOLUCION --}}
            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Fecha de Devolución (Estimada)
                </label>

                <input type="date"
                    name="fecha_devolucion"
                    class="form-control"
                    value="{{ old('fecha_devolucion') }}">

            </div>

        </div>

        {{-- ESTADO --}}
        <div class="mb-3">

            <label class="form-label">
                Estado Inicial
            </label>

            <select name="estado" class="form-control">

                <option value="Prestado"
                    {{ old('estado') == 'Prestado' ? 'selected' : '' }}>

                    Prestado

                </option>

                <option value="Devuelto"
                    {{ old('estado') == 'Devuelto' ? 'selected' : '' }}>

                    Devuelto (Entregado al instante)

                </option>

            </select>

        </div>

        {{-- OBSERVACION --}}
        <div class="mb-3">

            <label class="form-label">
                Observación
            </label>

            <textarea name="observacion"
                class="form-control"
                rows="3"
                placeholder="Ej: Se entrega sin pilas">{{ old('observacion') }}</textarea>

        </div>

        {{-- BOTONES --}}
        <div class="d-flex justify-content-between mt-4">

            <a href="{{ route('prestamos.index') }}"
               class="btn btn-outline-secondary">

                ⬅️ Cancelar

            </a>

            <button type="submit"
                    class="btn btn-primary px-4">

                💾 Registrar Préstamo

            </button>

        </div>

    </form>

</div>

@endsection