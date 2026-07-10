@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="row justify-content-center">

        <div class="col-md-11">

            <div class="card shadow border-0">

                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">

                    <h5 class="mb-0">
                        <i class="bi bi-shield-check me-2"></i>
                        Auditoría de Accesos
                    </h5>


                    <a href="{{ route('usuarios.index') }}"
                       class="btn btn-light btn-sm">

                        <i class="bi bi-arrow-left me-1"></i>
                        Volver Usuarios

                    </a>

                </div>


                <div class="card-body">


                    <div class="table-responsive">

                        <table class="table table-hover align-middle">


                            <thead class="table-light">

                                <tr>

                                    <th>Usuario</th>

                                    <th>Correo</th>

                                    <th>Rol</th>

                                    <th>Acción</th>

                                    <th>Navegador</th>

                                    <th>Fecha</th>

                                </tr>

                            </thead>


                            <tbody>


                                @forelse($auditorias as $auditoria)

                                <tr>


                                    <td class="fw-bold">

                                        {{ $auditoria->user->name ?? 'Usuario eliminado' }}

                                    </td>


                                    <td>

                                        {{ $auditoria->email ?? 'N/A' }}

                                    </td>


                                    <td>

                                        @if($auditoria->rol == 'administrador')

                                            <span class="badge bg-danger">
                                                Administrador
                                            </span>


                                        @elseif($auditoria->rol == 'mantenimiento')

                                            <span class="badge bg-primary">
                                                Mantenimiento
                                            </span>


                                        @elseif($auditoria->rol == 'directiva')

                                            <span class="badge bg-info text-dark">
                                                Directiva
                                            </span>


                                        @else

                                            <span class="badge bg-secondary">
                                                Sin rol
                                            </span>

                                        @endif

                                    </td>


                                    <td>

                                        @if($auditoria->accion == 'LOGIN')

                                            <span class="badge bg-success">
                                                Inició Sesión
                                            </span>

                                        @elseif($auditoria->accion == 'LOGOUT')

                                            <span class="badge bg-danger">
                                                Cerró Sesión
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">
                                                {{ $auditoria->accion }}
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        {{ $auditoria->navegador ?? 'N/A' }}

                                    </td>


                                    <td>

                                        {{ $auditoria->created_at->format('d/m/Y H:i:s') }}

                                    </td>


                                </tr>


                                @empty

                                <tr>

                                    <td colspan="6" class="text-center text-muted">

                                        No existen registros de auditoría.

                                    </td>

                                </tr>

                                @endforelse


                            </tbody>


                        </table>


                    </div>


                    {{-- PAGINACIÓN --}}

                    <div class="mt-3">

                        {{ $auditorias->links() }}

                    </div>


                </div>

            </div>

        </div>

    </div>

</div>

@endsection