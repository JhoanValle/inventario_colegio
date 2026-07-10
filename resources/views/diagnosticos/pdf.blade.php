<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Diagnósticos IA</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 20px;
        }

        /* =========================
            HEADER - COLOR VIOLETA TÉCNICO
        ========================= */
        .header {
            width: 100%;
            border-bottom: 3px solid #6f42c1; /* Púrpura IA */
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .logo {
            width: 85px;
        }

        .header-table {
            width: 100%;
        }

        .header-table td {
            vertical-align: top;
            border: none;
        }

        .institucion {
            text-align: center;
        }

        .institucion h1 {
            margin: 0;
            font-size: 17px;
            color: #6f42c1;
        }

        .institucion h2 {
            margin: 4px 0;
            font-size: 13px;
            color: #444;
        }

        .institucion p {
            margin: 1px 0;
            font-size: 10px;
            color: #555;
        }

        /* =========================
            TITULO Y DESCRIPCIÓN
        ========================= */
        .titulo-seccion {
            text-align: center;
            margin-bottom: 20px;
        }

        .titulo-seccion h3 {
            margin: 0;
            text-transform: uppercase;
            color: #6f42c1;
            font-size: 14px;
            letter-spacing: 1px;
        }

        .titulo-seccion p {
            margin-top: 5px;
            font-size: 10px;
            color: #777;
        }

        /* =========================
            TABLA DE DIAGNÓSTICOS
        ========================= */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        thead {
            background: #6f42c1;
            color: white;
        }

        th {
            padding: 8px 4px;
            font-size: 9px;
            text-align: center;
            text-transform: uppercase;
            border: 1px solid #6f42c1;
        }

        td {
            padding: 7px 5px;
            border: 1px solid #dcdcdc;
            font-size: 9px;
            vertical-align: top;
            word-wrap: break-word;
        }

        tbody tr:nth-child(even) {
            background: #fdfaff; /* Fondo lila muy suave */
        }

        /* Estilo para el nivel de riesgo */
        .riesgo-texto {
            text-align: center;
            font-weight: bold;
            color: #6f42c1;
        }

        /* =========================
            FOOTER / FIRMA
        ========================= */
        .footer {
            margin-top: 45px;
        }

        .footer-table {
            width: 100%;
        }

        .footer-table td {
            border: none;
        }

        .fecha-emision {
            font-size: 10px;
            color: #666;
            vertical-align: bottom;
        }

        .firma-container {
            text-align: center;
            width: 240px;
            margin-left: auto;
        }

        .firma-img {
            width: 150px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .firma-nombre {
            font-weight: bold;
            color: #333;
            display: block;
            margin-top: 5px;
            border-top: 1px dotted #6f42c1; /* Punteado en color lila */
            padding-top: 5px;
        }

        .firma-cargo {
            color: #777;
            display: block;
            font-size: 9px;
            margin-top: 2px;
        }

    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <table class="header-table">
            <tr>
                <td width="15%">
                    <img src="{{ public_path('img/logoinicio1.jpg') }}" class="logo">
                </td>
                <td width="85%" class="institucion">
                    <h1>INSTITUCIÓN EDUCATIVA N°14011</h1>
                    <h2>NUESTRA SEÑORA DEL PILAR</h2>
                    <p>Av. José Carlos Mariátegui S/N, Piura - Veintiséis de Octubre</p>
                    <p>Teléfono: (073) 623675 | Email: ienstrasradelpilar@gmail.com</p>
                    <p>RUC: 20484300586 | Institución Pública | Fundación: 1965</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- TITULO -->
    <div class="titulo-seccion">
        <h3>Reporte de Diagnósticos Generados por IA</h3>
        <p>Resultados del análisis técnico inteligente para la gestión de infraestructura tecnológica</p>
    </div>

    <!-- TABLA -->
    <table>
        <thead>
            <tr>
                <th width="12%">Equipo</th>
                <th width="14%">Problema</th>
                <th width="15%">Causas</th>
                <th width="19%">Soluciones sugeridas</th>
                <th width="18%">Recomendaciones</th>
                <th width="10%">Riesgo</th>
                <th width="12%">Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($diagnosticos as $d)
                <tr>
                    <td style="font-weight: bold;">{{ $d->equipo->nombre ?? 'N/A' }}</td>
                    <td>{{ $d->problema }}</td>
                    <td style="white-space: pre-line;">{{ $d->causa }}</td>
                    <td style="white-space: pre-line;">{{ $d->solucion }}</td>
                    <td style="white-space: pre-line;">{{ $d->recomendacion }}</td>
                    <td class="riesgo-texto">{{ $d->riesgo }}</td>
                    <td style="text-align: center;">{{ $d->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        <table class="footer-table">
            <tr>
                <td class="fecha-emision" width="45%">
                    <strong>Emitido por IA el:</strong> {{ now()->format('d/m/Y H:i A') }}
                </td>
                <td width="55%">
                    <div class="firma-container">
                        <!-- Firma sin línea sólida -->
                        <img src="{{ public_path('img/docenteaipfirma.jpg') }}" class="firma-img">
                        
                        <span class="firma-nombre">Responsable del Área AIP</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>