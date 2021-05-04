<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\MemberBatch;

class MemberBatchRegistration extends Notification
{
    use Queueable;

    private $memberBatch;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(MemberBatch $memberBatch)
    {
        $this->memberBatch = $memberBatch;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
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
                    ->subject('Pendaftaran '.$this->memberBatch->batch->full_name)
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
            'type'=>'member_batch_registration',
            'link'=>$this->getLink(),
            'message'=>$this->getMessage(),
        ];
    }

    private function getLink()
    {
        return route('member.batches.detail', [$this->memberBatch->id]);
    }

    private function getMessage()
    {
        return __('member.registration', ['member'=>$this->memberBatch->member->full_name,'batch'=>$this->memberBatch->batch->full_name]);
    }
}
