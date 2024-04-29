<?php

namespace App\Notifications;

use App\Models\MemberBatch;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BatchRegistration extends Notification
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
            'type' => 'batch_registration',
            'link' => $this->getLink(),
            'message' => $this->getMessage(),
        ];
    }

    private function getLink()
    {
        return route('admin.courses.batches.members.edit', [$this->memberBatch->batch->course_id, $this->memberBatch->batch_id, $this->memberBatch->id]);
    }

    private function getMessage()
    {
        $message = __('user.registration', ['member' => $this->memberBatch->member->full_name, 'batch' => $this->memberBatch->batch->full_name]);
        if ($this->memberBatch->member->is_overseas) {
            $message .= ' [Luar Negeri]';
        }
        if ($this->memberBatch->reseat) {
            $message .= ' [Reseat]';
        }

        return $message;
    }
}
