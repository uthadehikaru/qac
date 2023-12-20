<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class EventCreated extends Notification implements ShouldQueue
{
    use Queueable;

    var $event, $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Event $event, User $user)
    {
        $this->event = $event;
        $this->user = $user;
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
        $message = (new MailMessage)
                    ->subject('Event QAC : '.$this->event->title)
                    ->line($this->getMessage())
                    ->action(__('Detail'), $this->getLink())
                    ->markdown('vendor\notifications\email', ['token' => Crypt::encryptString($this->user->id)])
                    ;
        
        if($this->event->attachment)
            $message->attach(storage_path('app/public/'.$this->event->attachment));
        
        $message->viewData['event'] = $this->event;
        $message->viewData['user'] = $notifiable;

        Log::channel('email')->info('Event '.$this->event->title.' sent to '.$notifiable->email);
        
        return $message;
    }

    private function getLink()
    {
        return route('event.detail', $this->event->slug);
    }

    private function getMessage()
    {
        $message = __('event.created', ['event'=>$this->event->title,'date'=>$this->event->event_at->format('d M Y H:i')]);
        $message .= "<br /><br />".nl2br($this->event->content);
        $message .= '<br /><br /><a href="http://www.google.com/calendar/render?action=TEMPLATE&text='.urlencode($this->event->title).'&dates='.$this->event->event_at->format('Ymd\\THi00').'/'.$this->event->event_at->addHour()->format('Ymd\\THi00').'&ctz=Asia/Jakarta&trp=false&sprop=&sprop=name:"
        target="_blank" rel="nofollow"
                    class="pointer text-blue-500 ml-2">
                    Buat Notifikasi di Google Calendar</a>';
        return new HtmlString($message);
    }
}
