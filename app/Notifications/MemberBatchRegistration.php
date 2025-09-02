<?php

namespace App\Notifications;

use App\Models\MemberBatch;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MemberBatchRegistration extends Notification
{
    use Queueable;

    private $memberBatch;
    private $batchName;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(MemberBatch $memberBatch)
    {
        $this->memberBatch = $memberBatch;
        
        $this->batchName = $this->memberBatch->batch->full_name;
        if ($this->memberBatch->session == 'bundling') {
            $this->batchName = $this->memberBatch->batch->course->name. ' Bundling';
        }
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
            ->subject('Pendaftaran '.$this->batchName)
            ->line($this->getMessage())
            ->action(__('WA Admin QAC'), $this->getLink());
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
            'type' => 'member_batch_registration',
            'link' => $this->getLink(),
            'message' => $this->getMessage(),
        ];
    }

    private function getLink()
    {
        return 'https://wa.me/'.\App\Models\System::value('whatsapp').'?text='.urlencode('Assalaamu\'alaikum QAC, saya sudah mendaftar '.$this->batchName.' atas nama '.$this->memberBatch->member->full_name.'. mohon dibantu untuk proses selanjutnya. terima kasih');
    }

    private function getMessage()
    {
        return __('member.registration', ['member' => $this->memberBatch->member->full_name, 'batch' => $this->batchName]);
    }
}
