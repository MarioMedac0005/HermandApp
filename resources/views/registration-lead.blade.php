<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Registro Lead</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f3f4f6; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased;">
    
    <!-- Wrapper -->
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #f3f4f6; padding: 20px 0;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); overflow: hidden;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #1f2937; padding: 40px 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 600; letter-spacing: -0.5px;">Nuevo Registro Recibido</h1>
                            <p style="color: #9ca3af; margin: 10px 0 0 0; font-size: 16px;">Revisar datos para creación en backend</p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            
                            <!-- Organization Type Badge -->
                            <div style="text-align: center; margin-bottom: 35px;">
                                <span style="background-color: #e0e7ff; color: #3730a3; padding: 8px 16px; border-radius: 50px; font-weight: bold; font-size: 14px; text-transform: uppercase;">
                                    TIPO: {{ $data['orgType'] }}
                                </span>
                            </div>

                            <!-- Section: Account -->
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 35px;">
                                <tr>
                                    <td style="padding-bottom: 15px; border-bottom: 2px solid #f3f4f6;">
                                        <h3 style="margin: 0; color: #111827; font-size: 18px; text-transform: uppercase; letter-spacing: 0.05em;">👤 Datos de la Cuenta</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 15px;">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding: 8px 0; color: #6b7280; font-size: 14px; width: 120px;">Nombre</td>
                                                <td style="padding: 8px 0; color: #111827; font-size: 15px; font-weight: 500;">{{ $data['account']['firstName'] }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #6b7280; font-size: 14px; width: 120px;">Apellidos</td>
                                                <td style="padding: 8px 0; color: #111827; font-size: 15px; font-weight: 500;">{{ $data['account']['lastName'] }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #6b7280; font-size: 14px; width: 120px;">Email</td>
                                                <td style="padding: 8px 0; color: #111827; font-size: 15px; font-weight: 500;">
                                                    <a href="mailto:{{ $data['account']['email'] }}" style="color: #2563eb; text-decoration: none;">{{ $data['account']['email'] }}</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Section: Organization -->
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding-bottom: 15px; border-bottom: 2px solid #f3f4f6;">
                                        <h3 style="margin: 0; color: #111827; font-size: 18px; text-transform: uppercase; letter-spacing: 0.05em;">🏢 Datos de la Organización</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 15px;">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding: 8px 0; color: #6b7280; font-size: 14px; width: 120px; vertical-align: top;">Nombre</td>
                                                <td style="padding: 8px 0; color: #111827; font-size: 15px; font-weight: 500;">{{ $data['organization']['name'] }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #6b7280; font-size: 14px; width: 120px; vertical-align: top;">Ciudad</td>
                                                <td style="padding: 8px 0; color: #111827; font-size: 15px; font-weight: 500;">{{ $data['organization']['city'] }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #6b7280; font-size: 14px; width: 120px; vertical-align: top;">NIF/CIF</td>
                                                <td style="padding: 8px 0; color: #111827; font-size: 15px; font-weight: 500;">{{ $data['organization']['nifCif'] }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; color: #6b7280; font-size: 14px; width: 120px; vertical-align: top;">Email Org.</td>
                                                <td style="padding: 8px 0; color: #111827; font-size: 15px; font-weight: 500;">
                                                    <a href="mailto:{{ $data['organization']['email'] }}" style="color: #2563eb; text-decoration: none;">{{ $data['organization']['email'] }}</a>
                                                </td>
                                            </tr>

                                            @if(!empty($data['organization']['phone']))
                                            <tr>
                                                <td style="padding: 8px 0; color: #6b7280; font-size: 14px; width: 120px; vertical-align: top;">Teléfono</td>
                                                <td style="padding: 8px 0; color: #111827; font-size: 15px; font-weight: 500;">{{ $data['organization']['phone'] }}</td>
                                            </tr>
                                            @endif

                                            @if(!empty($data['organization']['canonicalSeat']))
                                            <tr>
                                                <td style="padding: 8px 0; color: #6b7280; font-size: 14px; width: 120px; vertical-align: top;">Sede Canónica</td>
                                                <td style="padding: 8px 0; color: #111827; font-size: 15px; font-weight: 500;">{{ $data['organization']['canonicalSeat'] }}</td>
                                            </tr>
                                            @endif

                                            @if(!empty($data['organization']['rehearsalPlace']))
                                            <tr>
                                                <td style="padding: 8px 0; color: #6b7280; font-size: 14px; width: 120px; vertical-align: top;">Sitio Ensayo</td>
                                                <td style="padding: 8px 0; color: #111827; font-size: 15px; font-weight: 500;">{{ $data['organization']['rehearsalPlace'] }}</td>
                                            </tr>
                                            @endif

                                            @if(!empty($data['organization']['description']))
                                            <tr>
                                                <td style="padding: 8px 0; color: #6b7280; font-size: 14px; width: 120px; vertical-align: top;">Descripción</td>
                                                <td style="padding: 8px 0; color: #111827; font-size: 14px; line-height: 1.5;">{{ $data['organization']['description'] }}</td>
                                            </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0; color: #9ca3af; font-size: 12px;">© HermandApp - Notificación automática</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
