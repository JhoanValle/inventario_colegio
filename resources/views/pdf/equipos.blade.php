<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Equipos - {{ $mes }}</title>

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
            border-bottom: 3px solid #0d6efd; /* Azul para equipos */
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
            color: #0d6efd;
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
            background: #f4f7fb;
            border-left: 5px solid #0d6efd;
            padding: 12px 15px;
            margin-bottom: 25px;
            border-radius: 8px;
        }

        .info-box h3 {
            margin-top: 0;
            color: #0d6efd;
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
            color: #0d6efd;
            font-size: 18px;
            text-transform: uppercase;
        }

        .titulo-reporte p {
            margin-top: 5px;
            color: #666;
        }

        /* =========================
            TABLA
        ========================= */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #0d6efd;
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
            background: #f8f9fa;
        }

        /* =========================
            FOOTER / FIRMAS (SIN LÍNEA)
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
        <h3>Información Institucional</h3>
        <p><strong>Director(a):</strong> Maritza Roxana Tomapasca Ulloa</p>
        <p><strong>Razón Social:</strong> Educación Básica</p>
        <p><strong>Reporte generado por:</strong> Sistema Web de Inventario AIP</p>
    </div>

    <!-- TITULO -->
    <div class="titulo-reporte">
        <h2>Reporte Mensual de Equipos</h2>
        <p>Inventario general de bienes correspondiente al mes de <strong>{{ $mes }}</strong></p>
    </div>

    <!-- TABLA -->
    <table>
        <thead>
            <tr>
                <th width="18%">Código</th>
                <th width="32%">Nombre</th>
                <th width="20%">Estado</th>
                <th width="30%">Ubicación</th>
            </tr>
        </thead>
        <tbody>
            @forelse($equipos as $e)
                <tr>
                    <td style="font-weight: bold; text-align: center;">
                        {{ $e->codigo_patrimonial }}
                    </td>
                    <td>{{ $e->nombre }}</td>
                    <td style="text-align: center;">{{ $e->estado }}</td>
                    <td>{{ $e->ubicacion }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding:20px; color: #999;">
                        No existen registros de equipos disponibles.
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
                    <strong>Fecha de emisión:</strong> {{ now()->format('d/m/Y') }}
                </td>
                <td class="firma" width="50%">
                    <div class="firma-container">
                        <!-- Firma electrónica -->
                        <img src="{{ public_path('img/docenteaipfirma.jpg') }}" class="firma-img">
                        
                        <span class="firma-nombre">Responsable del Área AIP</span>
                        
                    </div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>