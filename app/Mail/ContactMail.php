<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $phone, $message2)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->message2 = $message2;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this->from($this->email, 'The Grand Venice Mall')
                ->replyTo($this->email, $this->name)
                ->view('emailcontact')
                ->subject("Contact Request")
                ->with(['name' => $this->name, 'email' => $this->email,
                    'phone' => $this->phone,'message2' => $this->message2]);
    }
}
