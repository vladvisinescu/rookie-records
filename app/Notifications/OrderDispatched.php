<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderDispatched extends Notification
{
    use Queueable;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Good news!')
            ->line('Your order will be dispatched soon.')
            ->action('View order', route('shop.checkout.order.details', ['orderID' => $this->order->transaction_id]));
    }

    public function toDatabase($notifiable)
    {
        return $this->order->toArray();
    }
}
