<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OpenBatchInvitation extends Notification implements ShouldQueue
{
    use Queueable;

    private $batch;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($batch)
    {
        $this->batch = $batch;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Pendaftaran '.$this->batch->full_name.' Telah dibuka')
                    ->line($this->getMessage())
                    ->action(__('Daftar Sekarang'), $this->getLink());
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            
        ];
    }

    private function getLink()
    {
        return route('member.batch.detail', $this->batch->id);
    }

    private function getMessage()
    {
        return "Pendaftaran ".$this->batch->full_name.' telah dibuka mulai '.$this->batch->registration_duration
        .'. Kelas akan berlangsung '.$this->batch->duration.'. Daftarkan diri anda segera. klik tombol daftar sekarang!';
    }
}
