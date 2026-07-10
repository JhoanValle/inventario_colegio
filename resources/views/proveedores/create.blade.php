@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="card border-0 shadow-sm">

            {{-- HEADER --}}
            <div class="card-header bg-white border-0 py-3 px-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h4 class="mb-1 fw-semibold">
                            ➕ Registrar Nuevo Proveedor
                        </h4>

                        <small class="text-muted">
                            Completa la información del proveedor
                        </small>
                    </div>

                    <a href="{{ route('proveedores.index') }}"
                       class="btn btn-light border">

                        ⬅ Volver

                    </a>

                </div>

            </div>

            {{-- BODY --}}
            <div class="card-body px-4 py-4">

                {{-- ALERTA SUCCESS --}}
                @if(session('success'))

                    <div class="alert alert-success border-0 shadow-sm">

                        {{ session('success') }}

                    </div>

                @endif

                {{-- ALERTAS ERROR --}}
                @if ($errors->any())

                    <div class="alert alert-danger border-0 shadow-sm">

                        <ul class="mb-0">

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                <form method="POST"
                      action="{{ route('proveedores.store') }}">

                    @csrf

                    <div class="row">

                        {{-- NOMBRE --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-semibold">
                                Nombre del Proveedor
                            </label>

                            <input type="text"
                                   name="nombre"
                                   class="form-control @error('nombre') is-invalid @enderror"
                                   value="{{ old('nombre') }}"
                                   placeholder="Ejemplo: HP Perú"
                                   maxlength="255"
                                   required>

                            @error('nombre')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                        {{-- TELEFONO --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-semibold">
                                Teléfono
                            </label>

                            <input type="tel"
                                   name="telefono"
                                   class="form-control @error('telefono') is-invalid @enderror"
                                   value="{{ old('telefono') }}"
                                   placeholder="Ejemplo: 987654321 o +51 987654321"
                                   maxlength="20"
                                   required>

                            @error('telefono')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                        {{-- EMAIL --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-semibold">
                                Correo Electrónico
                            </label>

                            <input type="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   placeholder="Ejemplo: proveedor@gmail.com"
                                   maxlength="255"
                                   required>

                            @error('email')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                        {{-- DIRECCION --}}
                        <div class="col-md-6 mb-4">

                            <label class="form-label fw-semibold">
                                Dirección
                            </label>

                            <input type="text"
                                   name="direccion"
                                   class="form-control @error('direccion') is-invalid @enderror"
                                   value="{{ old('direccion') }}"
                                   placeholder="Ejemplo: Av. Grau 123"
                                   maxlength="255"
                                   required>

                            @error('direccion')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                    </div>

                    {{-- BOTONES --}}
                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('proveedores.index') }}"
                           class="btn btn-light border px-4">

                            Cancelar

                        </a>

                        <button type="submit"
                                class="btn btn-primary px-4">

                            💾 Guardar Proveedor

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
</div>

@endsection