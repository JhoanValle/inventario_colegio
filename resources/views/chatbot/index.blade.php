@extends('layouts.app')

@section('content')

@php
$equipos = \App\Models\Equipo::all();
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">🤖 Asistente Inteligente</h3>
        <small class="text-muted">
            Diagnóstico automático de equipos tecnológicos
        </small>
    </div>

    <a href="{{ route('diagnosticos.index') }}"
       class="btn btn-dark rounded-pill px-4">
        📋 Historial
    </a>

</div>

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <div class="row">

            <!-- FORMULARIO -->
            <div class="col-md-5 border-end">

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        💻 Equipo
                    </label>

                    <select id="equipo_id" class="form-select rounded-3">

                        <option value="">Seleccionar equipo</option>

                        @foreach($equipos as $e)

                            <option value="{{ $e->id }}">
                                {{ $e->nombre }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        📝 Describe el problema
                    </label>

                    <textarea
                        id="mensaje"
                        class="form-control rounded-3"
                        rows="7"
                        placeholder="Ejemplo: La computadora no enciende o muestra pantalla azul..."
                    ></textarea>

                </div>

                <button
                    class="btn btn-primary w-100 rounded-3 py-2 fw-semibold"
                    onclick="consultar()">

                    <i class="bi bi-cpu"></i>
                    Analizar Problema

                </button>

            </div>

            <!-- RESPUESTA -->
            <div class="col-md-7">

                <div id="respuesta" class="ps-md-3 mt-4 mt-md-0">

                    <div class="text-center text-muted py-5">

                        <i class="bi bi-robot fs-1"></i>

                        <p class="mt-3 mb-0">
                            El diagnóstico generado por IA aparecerá aquí
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

function consultar() {

    let mensaje = document.getElementById('mensaje').value.trim();
    let equipo_id = document.getElementById('equipo_id').value;

    if (!mensaje) {
        alert("Escribe el problema");
        return;
    }

    if (!equipo_id) {
        alert("Selecciona un equipo");
        return;
    }

    document.getElementById('respuesta').innerHTML = `

        <div class="text-center py-5">

            <div class="spinner-border text-primary"></div>

            <p class="mt-3 text-muted">
                Analizando problema con IA...
            </p>

        </div>

    `;

    fetch("{{ route('chatbot.preguntar') }}", {

        method: "POST",

        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },

        body: JSON.stringify({
            mensaje: mensaje,
            equipo_id: equipo_id
        })

    })

    .then(res => res.json())

    .then(data => {

        if (data.error) {

            document.getElementById('respuesta').innerHTML = `

                <div class="alert alert-danger rounded-4">
                    ${data.error}
                </div>

            `;

            return;
        }

        function listaHTML(lista) {

            if (!lista || lista.length === 0)
                return "<li>No disponible</li>";

            return lista.map(item => `
                <li class="mb-2">${item}</li>
            `).join('');
        }

        let riesgo = data.riesgo || 'No definido';

        let color = "secondary";

        if (riesgo.toLowerCase().includes("alto"))
            color = "danger";

        else if (riesgo.toLowerCase().includes("medio"))
            color = "warning";

        else if (riesgo.toLowerCase().includes("bajo"))
            color = "success";

        document.getElementById('respuesta').innerHTML = `

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <h5 class="fw-bold mb-0">
                            📋 Diagnóstico generado
                        </h5>

                        <span class="badge bg-${color} px-3 py-2 rounded-pill">
                            ${riesgo}
                        </span>

                    </div>

                    <div class="mb-4">

                        <h6 class="fw-bold text-primary">
                            🔍 Posibles causas
                        </h6>

                        <ul class="mt-3">
                            ${listaHTML(data.causas)}
                        </ul>

                    </div>

                    <div class="mb-4">

                        <h6 class="fw-bold text-success">
                            🛠 Posibles soluciones
                        </h6>

                        <ul class="mt-3">
                            ${listaHTML(data.soluciones)}
                        </ul>

                    </div>

                    <div>

                        <h6 class="fw-bold text-warning">
                            💡 Recomendaciones
                        </h6>

                        <ul class="mt-3">
                            ${listaHTML(data.recomendaciones)}
                        </ul>

                    </div>

                </div>

            </div>

        `;
    })

    .catch(error => {

        document.getElementById('respuesta').innerHTML = `

            <div class="alert alert-danger rounded-4">
                Error al conectar con la IA
            </div>

        `;

        console.error(error);

    });
}

</script>

@endsection