@extends('layouts.app')  {{-- cambia por tu layout --}}

@section('content')
<div class="container-fluid px-4">

    <h1 class="mt-4">⚙️ Configuración</h1>

    
    @if (session('status') === 'config-updated')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Configuración guardada correctamente.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-building me-1"></i>
            Información de la Institución Educativa
        </div>
        <div class="card-body">

            
            <div class="text-center mb-4">
                <img src="{{ asset('img/logoinicio1.jpg') }}"
                     alt="Logo de la institución"
                     style="height: 80px; border-radius: 8px;">
            </div>

            <form action="{{ route('configuracion.update') }}" method="POST">
                @csrf

                <div class="row">
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre de la Institución <span class="text-danger">*</span></label>
                        <input type="text"
                               name="nombre_institucion"
                               class="form-control @error('nombre_institucion') is-invalid @enderror"
                               value="{{ old('nombre_institucion', $config->nombre_institucion) }}"
                               required>
                        @error('nombre_institucion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">RUC</label>
                        <input type="text"
                               name="ruc"
                               class="form-control @error('ruc') is-invalid @enderror"
                               value="{{ old('ruc', $config->ruc) }}">
                        @error('ruc')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Dirección</label>
                        <input type="text"
                               name="direccion"
                               class="form-control @error('direccion') is-invalid @enderror"
                               value="{{ old('direccion', $config->direccion) }}">
                        @error('direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text"
                               name="telefono"
                               class="form-control @error('telefono') is-invalid @enderror"
                               value="{{ old('telefono', $config->telefono) }}">
                        @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Institucional</label>
                        <input type="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $config->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Director/a</label>
                        <input type="text"
                               name="director"
                               class="form-control @error('director') is-invalid @enderror"
                               value="{{ old('director', $config->director) }}">
                        @error('director')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tipo de Institución</label>
                        <select name="tipo_institucion"
                                class="form-select @error('tipo_institucion') is-invalid @enderror">
                            <option value="">-- Seleccionar --</option>
                            @foreach(['Pública', 'Privada', 'Parroquial', 'Técnica'] as $tipo)
                                <option value="{{ $tipo }}"
                                    {{ old('tipo_institucion', $config->tipo_institucion) === $tipo ? 'selected' : '' }}>
                                    {{ $tipo }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_institucion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Año de Fundación</label>
                        <input type="number"
                               name="anio_fundacion"
                               class="form-control @error('anio_fundacion') is-invalid @enderror"
                               value="{{ old('anio_fundacion', $config->anio_fundacion) }}"
                               min="1900"
                               max="{{ date('Y') }}">
                        @error('anio_fundacion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-2">
                    <button type="submit" class="btn btn-primary">
                        💾 Guardar Configuración
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection