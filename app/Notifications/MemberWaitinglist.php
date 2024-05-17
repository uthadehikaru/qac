<?php

namespace App\Notifications;

use App\Models\Queue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MemberWaitinglist extends Notification implements ShouldQueue
{
    use Queueable;

    private $waitinglist;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Queue $waitinglist)
    {
        $this->waitinglist = $waitinglist;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
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
            ->subject('Pendaftaran Waiting list '.$this->waitinglist->course->name)
            ->line($this->getMessage())
            ->action(__('Detail'), $this->getLink());
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
            'type' => 'waitinglist',
            'link' => $this->getLink(),
            'message' => $this->getMessage(),
        ];
    }

    private function getLink()
    {
        return route('member.dashboard');
    }

    private function getMessage()
    {
        return __('member.waitinglist', ['member' => $this->waitinglist->member->full_name, 'course' => $this->waitinglist->course->name]);
    }
}
