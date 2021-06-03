<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WalletMail extends Mailable
{
    use Queueable, SerializesModels;

     public $msg1;
     public $txnid;
     public $msg2;
     public $balance;
     public $amount;
     public $defcurrency;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($msg1,$txnid,$msg2,$balance,$amount,$defcurrency)
    {
         $this->msg1    = $msg1;
         $this->txnid   = $txnid;
         $this->msg2    = $msg2;
         $this->balance = $balance;
         $this->amount  = $amount;
         $this->currency = $defcurrency;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.walletmail')->subject($this->defcurrency.' '.$this->amount. ' '.$this->msg1);
    }
}
