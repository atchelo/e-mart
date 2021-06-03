<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTicketToUser extends Mailable
{
    use Queueable, SerializesModels;
    public $hd;
    

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($hd)
    {
        
        $this->hd =$hd;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.ticket')->subject('#'.$this->hd->ticket_no.' Ticket has been created');
    }
}
