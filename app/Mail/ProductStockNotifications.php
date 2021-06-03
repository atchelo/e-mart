<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductStockNotifications extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $vars;
    public $msg2;
    public $proname;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($vars,$msg2,$proname)
    {
        $this->vars = $vars;
        $this->msg2 = $msg2;
        $this->proname = $proname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Your Item $this->proname is back in stock !")->markdown('email.productnotify');
    }
}
