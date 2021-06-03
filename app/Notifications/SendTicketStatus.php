<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\CustomDbChannel;

class SendTicketStatus extends Notification
{
    use Queueable;

    public $data1;
    public $data2;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data1,$data2)
    {
        $this->data1 = $data1;
        $this->data2 = $data2;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
        public function via($notifiable)
        {
            return [CustomDbChannel::class]; //<-- important custom Channel defined here
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
    public function toDatabase($notifiable)
    {
        return [

            'data' => $this->data1 ,
            'n_type' => 'ticket_replay',
            'url' => $this->data2

        ];
    }

}
