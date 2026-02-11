<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contrato de Servicios Musicales</title>
    <style>
        body {
            font-family: 'DejaVu Sans', serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            font-style: italic;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid #ccc;
            margin-bottom: 10px;
            padding-bottom: 5px;
        }
        .content {
            text-align: justify;
        }
        .parties {
            margin-bottom: 20px;
        }
        .party {
            margin-bottom: 10px;
        }
        .clauses {
            list-style-type: decimal;
            margin-left: 20px;
        }
        .clauses li {
            margin-bottom: 10px;
        }
        .signatures {
            margin-top: 60px;
            width: 100%;
        }
        .signature-block {
            width: 45%;
            display: inline-block;
            vertical-align: top;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 40px;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Contrato de Acompañamiento Musical</h1>
        <p>Documento formal de acuerdo entre partes</p>
    </div>

    <div class="content">
        <div class="section">
            <div class="section-title">Reunidos</div>
            <div class="parties">
                <div class="party">
                    <strong>De una parte:</strong><br>
                    D./Dña. Representante Legal de la <strong>{{ $brotherhood->name }}</strong>, con domicilio en {{ $brotherhood->city ?? '________________' }}, en adelante denominada "LA HERMANDAD".
                </div>
                <div class="party">
                    <strong>De otra parte:</strong><br>
                    D./Dña. Representante Legal de la <strong>{{ $band->name }}</strong>, con domicilio en {{ $band->city ?? '________________' }}, en adelante denominada "LA BANDA".
                </div>
            </div>
            <p>Ambas partes se reconocen mutuamente la capacidad legal necesaria para suscribir el presente CONTRATO DE SERVICIOS MUSICALES, y a tal efecto:</p>
        </div>

        <div class="section">
            <div class="section-title">Exponen</div>
            <p>Que LA HERMANDAD está interesada en contratar los servicios musicales de LA BANDA para el acompañamiento musical de su Estación de Penitencia / Salida Procesional, y LA BANDA está interesada en prestar dichos servicios, con arreglo a las siguientes:</p>
        </div>

        <div class="section">
            <div class="section-title">Cláusulas</div>
            <ol class="clauses">
                <li>
                    <strong>Objeto del Contrato:</strong><br>
                    LA BANDA se compromete a realizar el acompañamiento musical durante la procesión de {{ $procession ? $procession->name : 'la Titular de la Hermandad' }}, que tendrá lugar en la fecha: <strong>{{ \Carbon\Carbon::parse($contract->date)->format('d/m/Y') }}</strong>.
                </li>
                <li>
                    <strong>Compensación Económica:</strong><br>
                    Como contraprestación por los servicios prestados, LA HERMANDAD abonará a LA BANDA la cantidad total de <strong>{{ number_format($contract->amount, 2, ',', '.') }} €</strong>.
                </li>
                <li>
                    <strong>Forma de Pago:</strong><br>
                    El pago se realizará según lo acordado verbalmente o en documento anexo entre las partes, debiendo estar liquidado en su totalidad antes de la finalización de los servicios o en el plazo estipulado.
                </li>
                <li>
                    <strong>Obligaciones de la Banda:</strong><br>
                    LA BANDA se compromete a asistir con el número adecuado de componentes y uniformidad reglamentaria, así como a interpretar el repertorio musical acordado con LA HERMANDAD.
                </li>
                <li>
                    <strong>Incidencias Meteorológicas:</strong><br>
                    En caso de suspensión de la salida procesional por causas meteorológicas o de fuerza mayor:
                    <ul>
                        <li>Si la suspensión se produce antes de la salida de LA BANDA de su localidad de origen, se abonará el ____% del importe total.</li>
                        <li>Si la suspensión se produce estando LA BANDA ya en la localidad de destino o durante el recorrido, se abonará el 100% del importe total, salvo acuerdo expreso en contrario.</li>
                    </ul>
                </li>
                <li>
                    <strong>Jurisdicción:</strong><br>
                    Para cualquier divergencia que pudiera surgir en la interpretación o cumplimiento del presente contrato, ambas partes se someten a los Juzgados y Tribunales de {{ $brotherhood->city ?? 'la localidad de la Hermandad' }}, con renuncia a su propio fuero si lo tuvieren.
                </li>
            </ol>
        </div> <!-- End Clauses -->

        <div class="section">
             <p>Y en prueba de conformidad, firman el presente contrato por duplicado a un solo efecto, en {{ $brotherhood->city ?? '__________' }}, a {{ $date }}.</p>
        </div>

        <div class="signatures">
            <div class="signature-block">
                <p><strong>Por LA HERMANDAD</strong></p>
                <div class="signature-line"></div>
                <p>{{ $brotherhood->name }}</p>
            </div>
            
            <div class="signature-block" style="float: right;">
                <p><strong>Por LA BANDA</strong></p>
                <div class="signature-line"></div>
                <p>{{ $band->name }}</p>
            </div>
            <div style="clear: both;"></div>
        </div>

    </div>

    <div class="footer">
        <p>Documento generado digitalmente por HermandApp el {{ $date }}.</p>
    </div>

</body>
</html>
