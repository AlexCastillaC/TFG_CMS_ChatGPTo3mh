<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderStatusNotification;

class SendOrderStatusNotification implements ShouldQueue
{
    public function handle(OrderStatusChanged $event)
    {
        $order = $event->order;
        // Notificar al cliente y al vendedor
        Notification::send($order->client, new OrderStatusNotification($order));
        Notification::send($order->vendor, new OrderStatusNotification($order));
    }
}
