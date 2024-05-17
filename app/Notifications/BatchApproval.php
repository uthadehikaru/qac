<?php

namespace App\Notifications;

use App\Models\MemberBatch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BatchApproval extends Notification implements ShouldQueue
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
            ->line(__('batch.approval', ['batch' => $this->memberBatch->batch->full_name]))
            ->action(__('Detail'), route('member.batches.detail', $this->memberBatch->id));
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
            'type' => 'batch_approval',
            'link' => route('member.batches.detail', $this->memberBatch->id),
            'message' => __('batch.approval', ['batch' => $this->memberBatch->batch->full_name]),
        ];
    }
}
