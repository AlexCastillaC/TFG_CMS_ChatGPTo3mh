<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusNotification extends Notification
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
    
    public function via($notifiable)
    {
        return ['mail'];
    }
    
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Actualización del Estado de tu Pedido')
                    ->line('El estado de tu pedido #' . $this->order->id . ' ha cambiado a: ' . ucfirst($this->order->status))
                    ->action('Ver Pedido', url(route('order.show', $this->order->id)))
                    ->line('Gracias por confiar en nuestro servicio.');
    }
}
