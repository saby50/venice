<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FocMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

           return $this->from('venice@veniceindia.com', 'The Grand Venice Mall')
                ->replyTo('venice@veniceindia.com', $this->name)
                ->view('vendor.multiauth.admin.foc.mail')
                ->subject("Foc Request");
        
    }
}
