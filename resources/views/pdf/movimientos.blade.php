<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Movimientos - {{ $mes }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 30px;
        }

        /* =========================
            HEADER
        ========================= */
        .header {
            width: 100%;
            border-bottom: 3px solid #198754; 
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .logo {
            width: 90px;
        }

        .header-table {
            width: 100%;
        }

        .header-table td {
            vertical-align: top;
        }

        .institucion {
            text-align: center;
        }

        .institucion h1 {
            margin: 0;
            font-size: 18px;
            color: #198754;
        }

        .institucion h2 {
            margin: 5px 0;
            font-size: 14px;
            color: #444;
        }

        .institucion p {
            margin: 2px 0;
            font-size: 11px;
        }

        /* =========================
            INFO BOX
        ========================= */
        .info-box {
            background: #f1f8f4;
            border-left: 5px solid #198754;
            padding: 12px 15px;
            margin-bottom: 25px;
            border-radius: 8px;
        }

        .info-box h3 {
            margin-top: 0;
            color: #198754;
            font-size: 14px;
        }

        .info-box p {
            margin: 4px 0;
        }

        /* =========================
            TITULO REPORTE
        ========================= */
        .titulo-reporte {
            text-align: center;
            margin-bottom: 20px;
        }

        .titulo-reporte h2 {
            margin: 0;
            color: #198754;
            font-size: 18px;
            text-transform: uppercase;
        }

        .titulo-reporte p {
            margin-top: 5px;
            color: #666;
        }

        /* =========================
            TABLA DE DATOS
        ========================= */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #198754;
            color: white;
        }

        th {
            padding: 10px;
            font-size: 11px;
            text-align: center;
            text-transform: uppercase;
        }

        td {
            padding: 8px;
            border: 1px solid #dcdcdc;
            font-size: 10.5px;
            vertical-align: middle;
        }

        tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        .badge {
            padding: 3px 6px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 9px;
            background: #e9ecef;
            color: #495057;
        }

        /* =========================
            FOOTER / FIRMAS
        ========================= */
        .footer {
            margin-top: 50px;
        }

        .footer-table {
            width: 100%;
        }

        .footer-table td {
            border: none;
        }

        .fecha {
            text-align: left;
            font-size: 11px;
            color: #555;
            vertical-align: bottom;
        }

        .firma-container {
            text-align: center;
            width: 250px;
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
            border-top: 1px dotted #ccc;
            padding-top: 5px;
        }

        .firma-cargo {
            color: #666;
            display: block;
            font-size: 10px;
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

<!-- INFO BOX -->
<div class="info-box">
    <h3>Resumen del Reporte</h3>
    <p><strong>Tipo de Registro:</strong> Movimientos de Inventario </p>
    <p><strong>Periodo:</strong> {{ $mes }}</p>
    <p><strong>Generado por:</strong> Sistema Web de Inventario AIP</p>
</div>

<!-- TITULO -->
<div class="titulo-reporte">
    <h2>Reporte Detallado de Movimientos</h2>
    <p>Historial de acciones realizadas sobre los equipos tecnológicos</p>
</div>

<!-- TABLA -->
<table>
    <thead>
        <tr>
            <th width="18%">Equipo / Bien</th>
            <th width="10%">Acción</th>
            <th width="25%">Descripción</th>
            <th width="15%">Usuario</th>
            <th width="10%">IP</th>
            <th width="12%">Navegador</th>
            <th width="20%">Fecha y Hora</th>
        </tr>
    </thead>

    <tbody>
        @forelse($movimientos as $m)
            <tr>

                <td style="font-weight: bold;">
                    {{ $m->equipo->nombre ?? 'N/A' }}
                    <br>
                    <small style="color:#777; font-weight:normal;">
                        Cod: {{ $m->equipo->codigo_patrimonial ?? 'S/C' }}
                    </small>
                </td>

                <td style="text-align: center;">
                    <span class="badge">{{ strtoupper($m->accion) }}</span>
                </td>

                <td>{{ $m->descripcion }}</td>

                <td style="text-align: center;">
                    {{ $m->user->name ?? 'Sistema' }}
                </td>

                <td style="text-align: center;">
                    {{ $m->ip ?? '-' }}
                </td>

                <td style="text-align: center;">
                    {{ $m->navegador ?? '-' }}
                </td>

                <td style="text-align: center;">
                    {{ $m->created_at->format('d/m/Y') }}<br>
                    <small>{{ $m->created_at->format('h:i A') }}</small>
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align:center; padding:20px; color: #999;">
                    No se registraron movimientos en el periodo seleccionado.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- FOOTER -->
<div class="footer">
    <table class="footer-table">
        <tr>
            <td class="fecha" width="50%">
                <strong>Fecha de emisión:</strong> {{ now()->format('d/m/Y H:i') }}
            </td>
            <td class="firma" width="50%">
                <div class="firma-container">
                    <img src="{{ public_path('img/docenteaipfirma.jpg') }}" class="firma-img">
                    <span class="firma-nombre">Responsable del Área AIP</span>
                </div>
            </td>
        </tr>
    </table>
</div>

</body>
</html>