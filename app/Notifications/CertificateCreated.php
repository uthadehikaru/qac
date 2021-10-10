<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\MemberBatch;

class CertificateCreated extends Notification implements ShouldQueue
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
                    ->subject($this->memberBatch->batch->full_name. ' : Sertifikat Kelulusan')
                    ->line($this->getMessage())
                    ->action(__('Detail'), $this->getLink())
                    ->attach(storage_path('app/public/'.$this->memberBatch->file->filename));
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
            'type'=>'batch_status',
            'link'=>$this->getLink(),
            'message'=>$this->getMessage()
        ];
    }

    private function getLink()
    {
        return route('member.batches.detail', $this->memberBatch->id);
    }

    private function getMessage()
    {
        return "Selamat, anda telah menyelesaikan kelas ".$this->memberBatch->batch->full_name.". berikut terlampir sertifikat kelulusan anda. semoga bermanfaat";
    }
}
