<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendMbPayment extends Notification
{
    use Queueable;

    private $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
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
                    ->subject('Referência multibanco')
                    ->greeting('Olá, ' . $this->data['user']['name'] . '.')
                    ->line('Pode proceder ao pagamento da sua encomenda na referência abaixo.')
                    ->line('<strong>Produto: </strong>' . $this->data['purchase']['name'])
                    ->line('<table style="text-align: left; max-width: 300px; width: 100%;">' . $this->data['reference'] . '</table>')
                    ->line('<br>')
                    ->line('Obrigado por utilizar a nossa plataforma!');
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
