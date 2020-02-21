<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnitFirst extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($unit_phone, $pin,$unit_name,$unit_email)
    {
        $this->unit_phone = $unit_phone;
        $this->pin = $pin;
        $this->unit_name = $unit_name;
        $this->unit_email = $unit_email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@veniceindia.com', 'The Grand Venice Mall')
                 ->subject("Unit Created")
                ->view('unitfirstmail')
                ->with(['unit_name' => $this->unit_name, 'pin' => $this->pin,
                    'unit_phone' => $this->unit_phone, 'unit_email' => $this->unit_email]);
    }
}
