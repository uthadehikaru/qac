<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MemberOTP extends Notification implements ShouldQueue
{
    use Queueable;

    private $otp;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
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
            ->subject('Kode OTP')
            ->line($this->getMessage())
            ->action(__($this->otp), $this->getLink());
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [];
    }

    private function getLink()
    {
        return '#';
    }

    private function getMessage()
    {
        return 'Anda melakukan permintaan kode OTP untuk login ke web. Gunakan kode OTP dibawah untuk login ke akun anda. abaikan jika anda tidak merasa melakukannya.';
    }
}
