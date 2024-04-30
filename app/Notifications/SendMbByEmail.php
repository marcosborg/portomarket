<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendMbByEmail extends Notification
{
    use Queueable;

    private $body;

    /**
     * Create a new notification instance.
     */
    public function __construct($body)
    {
        $this->body = $body;
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
        return (new MailMessage)
                    ->subject('Dados para pagamento com referência multibanco')
                    ->greeting('Olá!')
                    ->line($this->body)
                    ->action('Área de utilizador', url('https://comerciodacidade.pt/admin'))
                    ->line('Obrigado por utilizar a nossa aplicação!')
                    ->salutation('Melhores cumprimentos,<br>Comercio da Cidade');
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
