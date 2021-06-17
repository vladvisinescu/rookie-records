<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class OrderConfirmed extends Notification
{
    use Queueable;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail', 'database', TelegramChannel::class];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->markdown('mail.order.confirmed', [
                'order' => $this->order
            ]);
    }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to('-330403026')
            ->content("New Order On Rookie Records")
            ->button('Visit Website', url('/'));
    }

    public function toDatabase($notifiable)
    {
        return $this->order->toArray();
    }
}
