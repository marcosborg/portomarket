<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ScheduleCancelNotification extends Notification
{
    use Queueable;

    private $shop_schedule;

    /**
     * Create a new notification instance.
     */
    public function __construct($shop_schedule)
    {
        $this->shop_schedule = $shop_schedule;
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
            ->subject('Cancelamento de serviço')
            ->greeting('Cancelamento de serviço')
            ->line('<strong>Empresa:</strong> ' . $this->shop_schedule->service_employee->shop_company->company->name)
            ->line('<strong>Serviço:</strong> ' . $this->shop_schedule->service->name)
            ->line('<strong>Funcionário:</strong> ' . $this->shop_schedule->service_employee->name)
            ->line('<strong>Dia:</strong> ' . Carbon::parse($this->shop_schedule->start_time)->format('d-m-Y') . ' das ' . Carbon::parse($this->shop_schedule->start_time)->format('H:i') . ' às ' . Carbon::parse($this->shop_schedule->end_time)->format('H:i') . '.')
            ->line('<strong>Cliente:</strong> ' . $this->shop_schedule->client->name . ' (' . $this->shop_schedule->client->email . ')')
            ->action('Consultar agenda', url('https://comerciodacidade.pt/admin/system-calendar'))
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