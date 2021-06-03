<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTicketToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $hd;
    public $get_user_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($hd,$get_user_name)
    {
        $this->hd = $hd;
        $this->get_user_name = $get_user_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.SendTicketToAdmin')->subject('#'.$this->hd->ticket_no.' Ticket Received');
    }
}
