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
                            ✏️ Editar Categoría
                        </h4>

                        <small class="text-muted">
                            Modifica la información de la categoría seleccionada
                        </small>
                    </div>

                    <a href="{{ route('categorias.index') }}"
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

                <form action="{{ route('categorias.update', $categoria->id) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    <div class="row">

                        {{-- NOMBRE --}}
                        <div class="col-md-12 mb-3">

                            <label class="form-label fw-semibold">
                                Nombre de la Categoría
                            </label>

                            <input type="text"
                                   name="nombre"
                                   class="form-control"
                                   value="{{ old('nombre', $categoria->nombre) }}"
                                   placeholder="Ejemplo: Laptops"
                                   oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')"
                                   required>

                        </div>

                        {{-- DESCRIPCION --}}
                        <div class="col-md-12 mb-4">

                            <label class="form-label fw-semibold">
                                Descripción
                            </label>

                            <textarea name="descripcion"
                                      class="form-control"
                                      rows="4"
                                      placeholder="Describe la categoría...">{{ old('descripcion', $categoria->descripcion) }}</textarea>

                        </div>

                    </div>

                    {{-- BOTONES --}}
                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('categorias.index') }}"
                           class="btn btn-light border px-4">

                            Cancelar

                        </a>

                        <button class="btn btn-primary px-4">

                            💾 Actualizar Categoría

                        </button>

                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection