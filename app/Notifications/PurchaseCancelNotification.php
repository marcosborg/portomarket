<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PurchaseCancelNotification extends Notification
{
    use Queueable;

    private $purchase;

    /**
     * Create a new notification instance.
     */
    public function __construct($purchase)
    {
        $this->purchase = $purchase;
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
            ->subject('Cancelamento de compra')
            ->greeting('Cancelamento de compra')
            ->line('<strong>Empresa:</strong> ' . $this->purchase->product->shop_product_categories[0]->company->name)
            ->line('<strong>Produto:</strong> ' . $this->purchase->name)
            ->line('<strong>Cliente:</strong> ' . $this->purchase->user->name . ' (' . $this->purchase->user->email . ')')
            ->action('Consultar encomendas', url('https://comerciodacidade.pt/admin/my-orders'))
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