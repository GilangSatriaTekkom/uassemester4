<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class TransactionNotification extends Notification
{
    use Queueable;

    protected $type;
    protected $amount;

    public function __construct($type, $amount)
    {
        $this->type = $type;
        $this->amount = $amount;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast', 'mail'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => ucfirst($this->type) . ' of ' . $this->amount . ' was successful.',
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => ucfirst($this->type) . ' of ' . $this->amount . ' was successful.',
        ]);
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Anda telah menerima transfer sebesar ' . $this->amount)
                    ->action('Lihat Detail', url('/'))
                    ->line('Terima kasih telah menggunakan layanan kami!');
    }
}
