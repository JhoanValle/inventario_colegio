@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-11">

            <div class="card shadow border-0">

                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">

                    <h5 class="mb-0">
                        <i class="bi bi-person-check-fill me-2"></i>
                        Gestión de Usuarios y Roles
                    </h5>


                    <a href="{{ route('auditorias.index') }}"
                       class="btn btn-light btn-sm">

                        <i class="bi bi-shield-check me-1"></i>
                        Auditoría de Accesos

                    </a>

                </div>


                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}

                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="alert"
                                    aria-label="Close">
                            </button>
                        </div>
                    @endif


                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-light">

                                <tr>
                                    <th>Nombre</th>
                                    <th>Correo Electrónico</th>
                                    <th>Rol Actual</th>

                                    <th class="text-center">
                                        Asignar Nuevo Rol
                                    </th>
                                </tr>

                            </thead>


                            <tbody>

                                @foreach($usuarios as $user)

                                <tr>

                                    <td class="fw-bold">
                                        {{ $user->name }}
                                    </td>


                                    <td>
                                        {{ $user->email }}
                                    </td>


                                    <td>

                                        @if($user->rol == 'administrador')

                                            <span class="badge bg-danger">
                                                Administrador
                                            </span>


                                        @elseif($user->rol == 'mantenimiento')

                                            <span class="badge bg-primary">
                                                Mantenimiento
                                            </span>


                                        @elseif($user->rol == 'directiva')

                                            <span class="badge bg-info text-dark">
                                                Directiva
                                            </span>


                                        @else

                                            <span class="badge bg-warning text-dark">
                                                Sin rol asignado
                                            </span>


                                        @endif

                                    </td>


                                    <td>

                                        <form action="{{ route('usuarios.updateRol', $user->id) }}"
                                              method="POST"
                                              class="d-flex justify-content-center gap-2">

                                            @csrf
                                            @method('PATCH')


                                            <select name="rol"
                                                    class="form-select form-select-sm"
                                                    style="width: 180px;">


                                                <option value=""
                                                    disabled
                                                    {{ $user->rol == null ? 'selected' : '' }}>
                                                    Seleccionar rol
                                                </option>


                                                <option value="administrador"
                                                    {{ $user->rol == 'administrador' ? 'selected' : '' }}>
                                                    Administrador
                                                </option>


                                                <option value="mantenimiento"
                                                    {{ $user->rol == 'mantenimiento' ? 'selected' : '' }}>
                                                    Mantenimiento
                                                </option>


                                                <option value="directiva"
                                                    {{ $user->rol == 'directiva' ? 'selected' : '' }}>
                                                    Directiva
                                                </option>


                                            </select>


                                            <button type="submit"
                                                    class="btn btn-sm btn-success">

                                                <i class="bi bi-save"></i>
                                                Guardar

                                            </button>


                                        </form>

                                    </td>

                                </tr>

                                @endforeach


                            </tbody>

                        </table>


                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
@endsection