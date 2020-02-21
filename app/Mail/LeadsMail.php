<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LeadsMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$email,$phone, $date,$time,$lead_type)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->date = $date;
        $this->time = $time;
        $this->lead_type = $lead_type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this->from('venice@veniceindia.com', 'The Grand Venice Mall')
                ->replyTo('venice@veniceindia.com', 'Venice India')
                ->view('leadsmail')
                ->subject("Lead Request: ".$this->lead_type)
                ->with(['name' => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'date' => $this->date,'time' => $this->time]);
    }
}
