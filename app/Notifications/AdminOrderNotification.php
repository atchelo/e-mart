<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\CustomDbChannel;

class AdminOrderNotification extends Notification
{
    use Queueable;


    public $productname;
    public $var_main;
    public $status;
    public $order_id;
    public $invcus;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invcus,$productname,$var_main,$status,$order_id)
    {
        $this->productname = $productname;
        $this->var_main    = $var_main;
        $this->status      = $status;
        $this->order_id    = $order_id;
        $this->invcus      = $invcus;
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

            'data' => 'For Order #'.$this->invcus->order_prefix.$this->order_id.' Item '.$this->productname.'( '.$this->var_main.' ) has been '.$this->status,
            'n_type' => 'order_v',
            'url' => 'admindesk/ord/canceled/'

        ];
    }
}
