<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\CustomDbChannel;

class OrderNotification extends Notification
{
    use Queueable;
    public $order_id;
    public $orderiddb;

    

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order_id,$orderiddb)
    {
        $this->order_id = $order_id;
        $this->orderiddb = $orderiddb;
       
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

            'data' => 'New Order #'.$this->orderiddb.' Received' ,
            'n_type' => 'order_v',
            'url' => 'admindesk/order/view/'.$this->order_id

        ];
    }
}
