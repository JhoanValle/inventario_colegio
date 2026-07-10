@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="mb-1 fw-bold">
            <i class="bi bi-box-seam text-primary"></i>
            Inventario de Equipos
        </h2>

        <small class="text-muted">
            Gestión y control de equipos tecnológicos
        </small>
    </div>

    
    @if(auth()->user()->rol == 'administrador')

    <a href="{{ route('equipos.create') }}" class="btn btn-primary shadow-sm">

        <i class="bi bi-plus-circle"></i>
        Nuevo Equipo

    </a>

    @endif

</div>



{{-- FILTROS --}}
<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <form method="GET" action="{{ route('equipos.index') }}">

            <div class="row g-3">

                
                <div class="col-md-2">

                    <input type="text"
                        name="codigo_patrimonial"
                        class="form-control"
                        placeholder="Código"
                        value="{{ request('codigo_patrimonial') }}">

                </div>

                
                <div class="col-md-3">

                    <input type="text"
                        name="nombre"
                        class="form-control"
                        placeholder="Nombre del equipo"
                        value="{{ request('nombre') }}">

                </div>

                
                <div class="col-md-2">

                    <select name="estado" class="form-select">

                        <option value="">Estado</option>

                        <option value="Operativo"
                            {{ request('estado') == 'Operativo' ? 'selected' : '' }}>
                            Operativo
                        </option>

                        <option value="En mantenimiento"
                            {{ request('estado') == 'En mantenimiento' ? 'selected' : '' }}>
                            Mantenimiento
                        </option>

                        <option value="Necesita Reparacion"
                            {{ request('estado') == 'Necesita Reparacion' ? 'selected' : '' }}>
                            Reparación
                        </option>

                        <option value="Malogrado"
                            {{ request('estado') == 'Malogrado' ? 'selected' : '' }}>
                            Malogrado
                        </option>

                        <option value="Perdido"
                            {{ request('estado') == 'Perdido' ? 'selected' : '' }}>
                            Perdido
                        </option>

                        {{-- NUEVO --}}
                        <option value="Inactivo"
                            {{ request('estado') == 'Inactivo' ? 'selected' : '' }}>
                            Inactivo
                        </option>

                    </select>

                </div>

                
                @php
                    $proveedores = \App\Models\Proveedor::all();
                @endphp

                <div class="col-md-3">

                    <select name="proveedor_id" class="form-select">

                        <option value="">Proveedor</option>

                        @foreach($proveedores as $p)

                            <option value="{{ $p->id }}"
                                {{ request('proveedor_id') == $p->id ? 'selected' : '' }}>

                                {{ $p->nombre }}

                            </option>

                        @endforeach

                    </select>

                </div>

                
                <div class="col-md-2">

                    <select name="anio_ingreso" class="form-select">

                        <option value="">Año</option>

                        @for($i = 2024; $i <= date('Y') + 5; $i++)

                            <option value="{{ $i }}"
                                {{ request('anio_ingreso') == $i ? 'selected' : '' }}>

                                {{ $i }}

                            </option>

                        @endfor

                    </select>

                </div>

            </div>

            
            <div class="mt-3 d-flex gap-2">

                <button class="btn btn-primary">

                    <i class="bi bi-search"></i>
                    Filtrar

                </button>

                <a href="{{ route('equipos.index') }}"
                    class="btn btn-outline-secondary">

                    <i class="bi bi-arrow-clockwise"></i>
                    Limpiar

                </a>

            </div>

        </form>

    </div>

</div>



{{-- TABLA --}}
<div class="card border-0 shadow-sm">

    <div class="table-responsive">

        <table class="table align-middle mb-0">

            <thead class="table-light">

                <tr>

                    <th>Código</th>
                    <th>Equipo</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Ubicación</th>
                    <th>Proveedor</th>
                    <th>Año</th>

                    
                    @if(auth()->user()->rol == 'administrador')

                        <th class="text-center">Acciones</th>

                    @endif

                </tr>

            </thead>

            <tbody>

                @forelse($equipos as $equipo)

                <tr>

                    
                    <td>

                        <span class="fw-semibold text-primary">

                            {{ $equipo->codigo_patrimonial }}

                        </span>

                    </td>

                    
                    <td>

                        <div class="d-flex align-items-center gap-3">

                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width:42px; height:42px;">

                                <i class="bi bi-laptop"></i>

                            </div>

                            <div>

                                <div class="fw-semibold">

                                    {{ $equipo->nombre }}

                                </div>

                                <small class="text-muted">

                                    Equipo registrado

                                </small>

                            </div>

                        </div>

                    </td>

                    
                    <td>

                        <span class="badge bg-light text-dark border">

                            {{ $equipo->categoria->nombre ?? 'Sin categoría' }}

                        </span>

                    </td>

                    
                    <td>

                        @if($equipo->estado == 'Operativo')

                            <span class="badge bg-success">
                                Operativo
                            </span>

                        @elseif($equipo->estado == 'En mantenimiento')

                            <span class="badge bg-warning text-dark">
                                Mantenimiento
                            </span>

                        @elseif($equipo->estado == 'Necesita Reparacion')

                            <span class="badge bg-info text-dark">
                                Reparación
                            </span>

                        @elseif($equipo->estado == 'Malogrado')

                            <span class="badge bg-danger">
                                Malogrado
                            </span>

                        @elseif($equipo->estado == 'Perdido')

                            <span class="badge bg-dark">
                                Perdido
                            </span>

                        {{-- NUEVO --}}
                        @elseif($equipo->estado == 'Inactivo')

                            <span class="badge bg-secondary">
                                Inactivo
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                {{ $equipo->estado }}
                            </span>

                        @endif

                    </td>

                    
                    <td>

                        <i class="bi bi-geo-alt text-danger"></i>

                        {{ $equipo->ubicacion }}

                    </td>

                    
                    <td>

                        {{ $equipo->proveedor->nombre ?? 'Sin proveedor' }}

                    </td>

                    
                    <td>

                        <span class="badge bg-primary">

                            {{ $equipo->anio_ingreso }}

                        </span>

                    </td>

                    
                    @if(auth()->user()->rol == 'administrador')

                    <td class="text-center">

                        <a href="{{ route('equipos.edit', $equipo->id) }}"
                            class="btn btn-warning btn-sm">

                            <i class="bi bi-pencil-square"></i>

                        </a>

                    </td>

                    @endif

                </tr>

                @empty

                <tr>

                    <td colspan="8" class="text-center py-5 text-muted">

                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>

                        No hay equipos registrados

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>



{{-- PAGINACIÓN --}}
<div class="mt-4 d-flex justify-content-center">

    {{ $equipos->appends(request()->all())->links() }}

</div>

@endsection