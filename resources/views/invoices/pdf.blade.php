<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura {{ $invoice->number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #1a1a1a;
            padding: 30px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Header Section */
        .header {
            margin-bottom: 50px;
        }

        .invoice-title {
            font-size: 32px;
            font-weight: 300;
            letter-spacing: 2px;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .invoice-number {
            font-size: 14px;
            color: #7f8c8d;
            font-weight: 400;
        }

        /* Company Info Grid */
        .company-info {
            display: table;
            width: 100%;
            margin-bottom: 40px;
            border-bottom: 1px solid #ecf0f1;
            padding-bottom: 25px;
        }

        .company-column {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 20px;
        }

        .company-column:last-child {
            padding-right: 0;
            text-align: right;
        }

        .company-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #95a5a6;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .company-name {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .company-detail {
            font-size: 11px;
            color: #5a6c7d;
            margin-bottom: 3px;
        }

        /* Invoice Details */
        .invoice-details {
            background-color: #f8f9fa;
            padding: 20px;
            margin-bottom: 30px;
            border-left: 3px solid #3498db;
        }

        .detail-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        .detail-row:last-child {
            margin-bottom: 0;
        }

        .detail-label {
            display: table-cell;
            width: 40%;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #7f8c8d;
            font-weight: 600;
        }

        .detail-value {
            display: table-cell;
            width: 60%;
            font-size: 11px;
            color: #2c3e50;
            font-weight: 500;
        }

        /* Items Table */
        .items-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #95a5a6;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table thead {
            border-bottom: 2px solid #2c3e50;
        }

        .items-table th {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #2c3e50;
            font-weight: 600;
            text-align: left;
            padding: 12px 0;
        }

        .items-table th:last-child {
            text-align: right;
        }

        .items-table tbody tr {
            border-bottom: 1px solid #ecf0f1;
        }

        .items-table td {
            padding: 15px 0;
            font-size: 11px;
            color: #34495e;
        }

        .items-table td:last-child {
            text-align: right;
            font-weight: 600;
        }

        .item-description {
            font-size: 10px;
            color: #7f8c8d;
            margin-top: 3px;
        }

        /* Totals Section */
        .totals-section {
            margin-top: 30px;
            text-align: right;
        }

        .total-row {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }

        .total-label {
            display: table-cell;
            width: 70%;
            font-size: 11px;
            color: #7f8c8d;
            text-align: right;
            padding-right: 20px;
        }

        .total-value {
            display: table-cell;
            width: 30%;
            font-size: 11px;
            color: #2c3e50;
            font-weight: 600;
            text-align: right;
        }

        .grand-total {
            border-top: 2px solid #2c3e50;
            padding-top: 15px;
            margin-top: 10px;
        }

        .grand-total .total-label {
            font-size: 14px;
            font-weight: 600;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .grand-total .total-value {
            font-size: 20px;
            color: #27ae60;
            font-weight: 700;
        }

        /* Payment Status */
        .payment-status {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px 20px;
            margin: 30px 0;
            text-align: center;
            font-weight: 600;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        /* Footer */
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ecf0f1;
            text-align: center;
        }

        .footer-text {
            font-size: 9px;
            color: #95a5a6;
            line-height: 1.6;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(39, 174, 96, 0.05);
            font-weight: 700;
            z-index: -1;
            text-transform: uppercase;
            letter-spacing: 5px;
        }
    </style>
</head>
<body>
    <div class="watermark">PAGADO</div>
    
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="invoice-title">FACTURA</div>
            <div class="invoice-number"># {{ $invoice->number }}</div>
        </div>

        <!-- Company Information -->
        <div class="company-info">
            <div class="company-column">
                <div class="company-label">De:</div>
                <div class="company-name">{{ $invoice->contract->band->name }}</div>
                <div class="company-detail">{{ $invoice->contract->band->city }}</div>
                <div class="company-detail">{{ $invoice->contract->band->email }}</div>
            </div>
            <div class="company-column">
                <div class="company-label">Para:</div>
                <div class="company-name">{{ $invoice->contract->brotherhood->name }}</div>
                <div class="company-detail">{{ $invoice->contract->brotherhood->city }}</div>
                <div class="company-detail">{{ $invoice->contract->brotherhood->email }}</div>
                @if($invoice->contract->brotherhood->phone_number)
                    <div class="company-detail">Tel: {{ $invoice->contract->brotherhood->phone_number }}</div>
                @endif
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <div class="detail-row">
                <div class="detail-label">Fecha de Emisión</div>
                <div class="detail-value">{{ \Carbon\Carbon::parse($invoice->issued_at)->format('d/m/Y') }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Fecha de Pago</div>
                <div class="detail-value">{{ \Carbon\Carbon::parse($invoice->contract->paid_at)->format('d/m/Y H:i') }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Actuación</div>
                <div class="detail-value">{{ $invoice->contract->performance_date->format('d/m/Y') }}</div>
            </div>
            @if($invoice->contract->procession)
                <div class="detail-row">
                    <div class="detail-label">Procesión</div>
                    <div class="detail-value">{{ $invoice->contract->procession->name }}</div>
                </div>
            @endif
        </div>

        <!-- Payment Status Badge -->
        <div class="payment-status">
            ✓ PAGO COMPLETADO
        </div>

        <!-- Items Table -->
        <div class="items-section">
            <div class="section-title">Detalles del Servicio</div>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Tipo</th>
                        <th>Importe</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div>Acompañamiento Musical</div>
                            <div class="item-description">
                                {{ $invoice->contract->procession ? $invoice->contract->procession->name : 'Servicio Musical' }}
                                @if($invoice->contract->duration)
                                    · Duración: {{ $invoice->contract->duration }}
                                @endif
                            </div>
                            @if($invoice->contract->approximate_route)
                                <div class="item-description">Recorrido: {{ $invoice->contract->approximate_route }}</div>
                            @endif
                        </td>
                        <td>{{ ucfirst($invoice->contract->performance_type) }}</td>
                        <td>{{ number_format($invoice->amount, 2, ',', '.') }} €</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Totals -->
        <div class="totals-section">
            <div class="total-row">
                <div class="total-label">Subtotal</div>
                <div class="total-value">{{ number_format($invoice->amount, 2, ',', '.') }} €</div>
            </div>
            @if($invoice->commission_amount && $invoice->commission_amount > 0)
                <div class="total-row">
                    <div class="total-label">Comisión de Plataforma</div>
                    <div class="total-value">- {{ number_format($invoice->commission_amount, 2, ',', '.') }} €</div>
                </div>
                <div class="total-row grand-total">
                    <div class="total-label">Total a Recibir</div>
                    <div class="total-value">{{ number_format($invoice->amount - $invoice->commission_amount, 2, ',', '.') }} €</div>
                </div>
            @else
                <div class="total-row grand-total">
                    <div class="total-label">Total</div>
                    <div class="total-value">{{ number_format($invoice->amount, 2, ',', '.') }} €</div>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-text">
                Este documento certifica el pago del contrato de servicios musicales<br>
                entre {{ $invoice->contract->band->name }} y {{ $invoice->contract->brotherhood->name }}.<br>
                <br>
                Generado automáticamente por HermandApp<br>
                {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
            </div>
        </div>
    </div>
</body>
</html>
