<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;
    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        $resetUrl =
            config('app.frontend_url') .
            '/reset-password?token=' . $this->token .
            '&email=' . urlencode($notifiable->email);

        return (new MailMessage)
            ->subject('Restablecimiento de contraseña - HermandApp')

            ->greeting('Hola ' . $notifiable->name . ',')

            ->line('Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en HermandApp.')

            ->line('Puedes establecer una nueva contraseña haciendo clic en el siguiente botón:')

            ->action('Restablecer contraseña', $resetUrl)

            ->line('Por motivos de seguridad, este enlace expirará en 60 minutos.')

            ->line('Si no solicitaste este cambio, puedes ignorar este mensaje. Tu contraseña actual seguirá siendo válida y no se realizará ninguna modificación.')

            ->line('Si tienes cualquier problema o duda, te recomendamos contactar con nuestro equipo de soporte.')

            ->salutation('Atentamente,' . "\n" . 'Equipo de HermandApp');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
