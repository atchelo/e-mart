<?php

namespace App\Notifications;

use App\Msg91Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SMSNotifcations extends Notification
{
    use Queueable;
    
    public $smsmsg;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($smsmsg)
    {
        $this->orderrow = Msg91Setting::where('key', '=', 'orders')->first();
        $this->smsmsg = $smsmsg;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['msg91'];
    }

    

    public function toMsg91($notifiable)
    {
        // return (new \Craftsys\Notifications\Messages\Msg91SMS)
        // ->content($this->smsmsg)
        // ->flow($this->orderrow->flow_id)
        // ->from($this->orderrow->sender_id);

        return (new \Craftsys\Notifications\Messages\Msg91SMS)
        ->content($this->smsmsg)
        ->from($this->orderrow->sender_id);

        // return (new \Craftsys\Notifications\Messages\Msg91SMS)
        // ->flow("your_flow_id");
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
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
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
            //
        ];
    }
}
