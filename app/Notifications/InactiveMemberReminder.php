<?php

namespace App\Notifications;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InactiveMemberReminder extends Notification
{
    use Queueable;

    public $member;
    public $inactiveDays;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Member $member, $inactiveDays)
    {
        $this->member = $member;
        $this->inactiveDays = $inactiveDays;
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
            ->subject('Reminder: Kamu tidak aktif belajar selama ' . $this->inactiveDays . ' hari!')
            ->view('emails.inactive-member-reminder', [
                'member' => $this->member,
                'inactiveDays' => $this->inactiveDays,
                'actionUrl' => $this->getLink(),
                'actionText' => 'Belajar Sekarang'
            ]);
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
            'type' => 'inactive_reminder',
            'link' => $this->getLink(),
            'message' => 'Reminder: Kamu tidak aktif belajar selama ' . $this->inactiveDays . ' hari!',
        ];
    }

    private function getLink()
    {
        return route('member.dashboard');
    }
}
