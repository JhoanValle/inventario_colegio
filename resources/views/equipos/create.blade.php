@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-9">

        <div class="card border-0 shadow-sm">

            {{-- HEADER --}}
            <div class="card-header bg-white border-0 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h4 class="mb-1 fw-semibold">
                            ➕ Registrar Nuevo Equipo
                        </h4>

                        <small class="text-muted">
                            Completa la información del equipo
                        </small>
                    </div>

                    <a href="{{ route('equipos.index') }}"
                       class="btn btn-light border">
                        ⬅ Volver
                    </a>

                </div>
            </div>

            {{-- BODY --}}
            <div class="card-body px-4 py-4">

                {{-- ALERTAS --}}
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('equipos.store') }}" method="POST">
                    @csrf

                    <div class="row">

                        {{-- CODIGO --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                Código Patrimonial
                            </label>

                            <input type="text"
                                name="codigo_patrimonial"
                                class="form-control"

                                value="{{ old('codigo_patrimonial') }}"

                                placeholder="Ejemplo: EQP20260001"

                                style="text-transform: uppercase;"

                                oninput="this.value = this.value.toUpperCase()"

                                pattern="[A-Z0-9]{11,20}"

                                minlength="11"
                                maxlength="20"

                                required>
                        </div>

                        {{-- NOMBRE --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                Nombre del Equipo
                            </label>

                            <input type="text"
                                name="nombre"
                                class="form-control"

                                value="{{ old('nombre') }}"

                                placeholder="Ejemplo: Laptop HP"
                                required>
                        </div>

                        {{-- CATEGORIA --}}
                        @php
                            $categorias = \App\Models\Categoria::orderBy('nombre', 'asc')->get();
                        @endphp

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                Categoría
                            </label>

                            <select name="categoria_id" class="form-select" required>

                                <option value="">
                                    -- Seleccionar --
                                </option>

                                @foreach($categorias as $c)

                                    <option value="{{ $c->id }}"
                                        {{ old('categoria_id') == $c->id ? 'selected' : '' }}>

                                        {{ $c->nombre }}

                                    </option>

                                @endforeach

                            </select>
                        </div>

                        {{-- ESTADO --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                Estado
                            </label>

                            <select name="estado"
                                    class="form-select"
                                    required>

                                <option value="">
                                    -- Seleccionar --
                                </option>

                                <option value="Operativo"
                                    {{ old('estado') == 'Operativo' ? 'selected' : '' }}>
                                    Operativo
                                </option>

                                <option value="En mantenimiento"
                                    {{ old('estado') == 'En mantenimiento' ? 'selected' : '' }}>
                                    En mantenimiento
                                </option>

                                <option value="Necesita Reparacion"
                                    {{ old('estado') == 'Necesita Reparacion' ? 'selected' : '' }}>
                                    Necesita Reparación
                                </option>

                                <option value="Malogrado"
                                    {{ old('estado') == 'Malogrado' ? 'selected' : '' }}>
                                    Malogrado
                                </option>

                                <option value="Perdido"
                                    {{ old('estado') == 'Perdido' ? 'selected' : '' }}>
                                    Perdido
                                </option>

                                <option value="Inactivo"
                                    {{ old('estado') == 'Inactivo' ? 'selected' : '' }}>
                                    Inactivo
                                </option>

                            </select>
                        </div>

                        {{-- UBICACION --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                Ubicación
                            </label>

                            <input type="text"
                                name="ubicacion"
                                class="form-control"

                                value="{{ old('ubicacion') }}"

                                placeholder="Ejemplo: Laboratorio AIP"
                                required>
                        </div>

                        {{-- AÑO --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                Año de Ingreso
                            </label>

                            <input type="number"
                                name="anio_ingreso"
                                class="form-control"

                                min="2000"
                                max="2100"

                                value="{{ old('anio_ingreso', date('Y')) }}"
                                required>
                        </div>

                        {{-- PROVEEDOR --}}
                        @php
                            $proveedores = \App\Models\Proveedor::where('estado', 'activo')
                                ->orderBy('nombre', 'asc')
                                ->get();
                        @endphp

                        <div class="col-md-12 mb-4">
                            <label class="form-label fw-semibold">
                                Proveedor
                            </label>

                            <select name="proveedor_id" class="form-select" required>

                                <option value="">
                                    -- Seleccionar --
                                </option>

                                @foreach($proveedores as $p)

                                    <option value="{{ $p->id }}"
                                        {{ old('proveedor_id') == $p->id ? 'selected' : '' }}>

                                        {{ $p->nombre }}

                                    </option>

                                @endforeach

                            </select>
                        </div>

                    </div>

                    {{-- BOTONES --}}
                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('equipos.index') }}"
                           class="btn btn-light border px-4">

                            Cancelar

                        </a>

                        <button class="btn btn-primary px-4">

                            💾 Guardar Equipo

                        </button>

                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection