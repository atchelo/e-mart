<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FullOrderCancelMail extends Mailable
{
    use Queueable, SerializesModels;
    public $inv_cus;
    public $orderid;
    public $status;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inv_cus,$orderid,$status)
    {
        $this->inv_cus = $inv_cus;
        $this->orderid = $orderid;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.fullordercancel')->subject('Order #'.$this->inv_cus->order_prefix.$this->orderid.' has been cancelled');
    }
}
