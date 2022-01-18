<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use App\Models\Event;

class EventCreated extends Notification implements ShouldQueue
{
    use Queueable;

    var $event;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
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
                    ->action(__('Detail'), $this->getLink());
        
        if($this->event->attachment)
            $message->attach(storage_path('app/public/'.$this->event->attachment));
        
        $message->viewData['event'] = $this->event;
        $message->viewData['user'] = $notifiable;
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
        return new HtmlString($message);
    }
}
