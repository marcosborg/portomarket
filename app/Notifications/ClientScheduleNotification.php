<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientScheduleNotification extends Notification
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
            ->subject('Marcação de serviço')
            ->greeting('Marcação de serviço')
            ->line('<strong>Empresa:</strong> ' . $this->data['company_name'])
            ->line('<strong>Serviço:</strong> ' . $this->data['service_name'])
            ->line('<strong>Funcionário:</strong> ' . $this->data['service_employee_name'])
            ->line('<strong>Endereço:</strong> ' . $this->data['company_address'])
            ->line('<strong>Contactos:</strong> ' . $this->data['company_contacts'])
            ->line('<strong>Dia:</strong> ' . Carbon::parse($this->data['start_time'])->format('d-m-Y') . ' das ' . Carbon::parse($this->data['start_time'])->format('H:i') . ' às ' . Carbon::parse($this->data['end_time'])->format('H:i') . '.')
            ->line('Obrigado por utilizar a nossa aplicação!');
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
