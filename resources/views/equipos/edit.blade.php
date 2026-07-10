@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">✏️ Editar Equipo</h3>

            <small class="text-muted">
                Modifica la información del equipo seleccionado
            </small>
        </div>

        <a href="{{ route('equipos.index') }}"
           class="btn btn-light border">

            <i class="bi bi-arrow-left"></i>
            Volver

        </a>
    </div>

    {{-- ERRORES --}}
    @if ($errors->any())

        <div class="alert alert-danger border-0 shadow-sm">

            <strong>Se encontraron errores:</strong>

            <ul class="mb-0 mt-2">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    {{-- CARD --}}
    <div class="card shadow-sm border-0">

        <div class="card-body p-4">

            <form action="{{ route('equipos.update', $equipo->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    {{-- CODIGO --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Código Patrimonial
                        </label>

                        <input
                            type="text"
                            name="codigo_patrimonial"
                            class="form-control"
                            value="{{ old('codigo_patrimonial', $equipo->codigo_patrimonial) }}"
                            style="text-transform: uppercase;"
                            oninput="this.value = this.value.toUpperCase()"
                            pattern="[A-Z0-9]{11,20}"
                            minlength="11"
                            maxlength="20"
                            required
                        >

                    </div>

                    {{-- NOMBRE --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Nombre del Equipo
                        </label>

                        <input
                            type="text"
                            name="nombre"
                            class="form-control"
                            value="{{ old('nombre', $equipo->nombre) }}"
                            required
                        >

                    </div>

                    {{-- CATEGORIA --}}
                    @php
                        $categorias = \App\Models\Categoria::orderBy('nombre', 'asc')->get();
                    @endphp

                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Categoría
                        </label>

                        <select name="categoria_id" class="form-select">

                            <option value="">
                                -- Seleccionar Categoría --
                            </option>

                            @foreach($categorias as $c)

                                <option value="{{ $c->id }}"
                                    {{ old('categoria_id', $equipo->categoria_id) == $c->id ? 'selected' : '' }}>

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
                                -- Seleccionar Estado --
                            </option>

                            <option value="Operativo"
                                {{ old('estado', $equipo->estado) == 'Operativo' ? 'selected' : '' }}>
                                Operativo
                            </option>

                            <option value="En mantenimiento"
                                {{ old('estado', $equipo->estado) == 'En mantenimiento' ? 'selected' : '' }}>
                                En mantenimiento
                            </option>

                            <option value="Necesita Reparacion"
                                {{ old('estado', $equipo->estado) == 'Necesita Reparacion' ? 'selected' : '' }}>
                                Necesita Reparación
                            </option>

                            <option value="Malogrado"
                                {{ old('estado', $equipo->estado) == 'Malogrado' ? 'selected' : '' }}>
                                Malogrado
                            </option>

                            <option value="Perdido"
                                {{ old('estado', $equipo->estado) == 'Perdido' ? 'selected' : '' }}>
                                Perdido
                            </option>

                            <option value="Inactivo"
                                {{ old('estado', $equipo->estado) == 'Inactivo' ? 'selected' : '' }}>
                                Inactivo
                            </option>

                        </select>

                    </div>

                    {{-- UBICACION --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Ubicación
                        </label>

                        <input
                            type="text"
                            name="ubicacion"
                            class="form-control"
                            value="{{ old('ubicacion', $equipo->ubicacion) }}"
                            required
                        >

                    </div>

                    {{-- AÑO --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label fw-semibold">
                            Año de Ingreso
                        </label>

                        <input
                            type="number"
                            name="anio_ingreso"
                            class="form-control"
                            min="2000"
                            max="2100"
                            value="{{ old('anio_ingreso', $equipo->anio_ingreso) }}"
                            required
                        >

                    </div>

                    {{-- PROVEEDOR --}}
                    @php
                        $proveedores = \App\Models\Proveedor::where('estado', 'activo')
                            ->orderBy('nombre', 'asc')
                            ->get();
                    @endphp

                    <div class="col-md-12 mb-3">

                        <label class="form-label fw-semibold">
                            Proveedor
                        </label>

                        <select name="proveedor_id" class="form-select">

                            <option value="">
                                -- Seleccionar Proveedor --
                            </option>

                            @foreach($proveedores as $p)

                                <option value="{{ $p->id }}"
                                    {{ old('proveedor_id', $equipo->proveedor_id) == $p->id ? 'selected' : '' }}>

                                    {{ $p->nombre }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                {{-- BOTONES --}}
                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a href="{{ route('equipos.index') }}"
                       class="btn btn-light border px-4">

                        Cancelar

                    </a>

                    <button class="btn btn-primary px-4">

                        <i class="bi bi-save"></i>
                        Actualizar Equipo

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection