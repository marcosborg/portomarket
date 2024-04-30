<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendAskForDelete extends Notification
{
    use Queueable;

    private $name;
    private $email;
    private $reason;

    /**
     * Create a new notification instance.
     */
    public function __construct($name, $email, $reason)
    {
        $this->name = $name;
        $this->email = $email;
        $this->reason = $reason;
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
            ->line('O cliente ' . $this->name . ' com o email ' . $this->email . ' quer apagar a sua conta.')
            ->line('Motivo: ' . $this->reason)
            ->line('Obrigado!');
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
