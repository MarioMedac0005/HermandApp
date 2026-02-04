<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud rechazada</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f3f4f6; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f3f4f6; padding: 20px 0;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0"
                    style="max-width: 600px; background-color: #ffffff; border-radius: 12px;
                          box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="background-color: #7f1d1d; padding: 40px 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 600;">
                                Solicitud rechazada
                            </h1>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">

                            <p style="font-size: 16px; color: #111827;">
                                Hola <strong>{{ $organizationRequest->payload['user']['name'] }}</strong>,
                            </p>

                            <p style="font-size: 15px; color: #374151; line-height: 1.6;">
                                Lamentamos informarte de que tu solicitud para registrar la organización
                                <strong>{{ $organizationRequest->payload['organization']['name'] }}</strong>
                                ha sido rechazada.
                            </p>

                            @if ($adminNotes)
                                <div
                                    style="background-color: #fef2f2; border: 1px solid #fecaca;
                                        padding: 16px; border-radius: 8px; margin: 25px 0;">
                                    <p style="margin: 0; font-size: 14px; color: #7f1d1d;">
                                        <strong>Motivo:</strong><br>
                                        {{ $adminNotes }}
                                    </p>
                                </div>
                            @endif

                            <!-- CTA -->
                            <div style="text-align: center; margin: 40px 0;">
                                <a href="{{ $retryUrl }}"
                                    style="background-color: #2563eb; color: #ffffff;
                                      padding: 14px 28px; border-radius: 8px;
                                      text-decoration: none; font-weight: 600;
                                      font-size: 15px; display: inline-block;">
                                    Volver a intentarlo
                                </a>
                            </div>

                            <p style="font-size: 14px; color: #6b7280;">
                                Puedes corregir los datos y enviar una nueva solicitud cuando quieras.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background-color: #f9fafb; padding: 20px; text-align: center;
                               border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0; color: #9ca3af; font-size: 12px;">
                                © {{ date('Y') }} HermandApp · Notificación automática
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>
