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
    public function __construct($order_id, $authorised,$percent,$foc_reason,$prevamount)
    {
        $this->order_id = $order_id;
        $this->authorised = $authorised;
        $this->percent = $percent;
        $this->foc_reason = $foc_reason;
        $this->prevamount = $prevamount;

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
                ->view('vendor.multiauth.admin.foc.mail')
                ->subject("New Foc Request - ".$this->order_id)
                ->with(['order_id' => $this->order_id, 'authorised' => $this->authorised,
                    'percent' => $this->percent,'foc_reason' => $this->foc_reason,'prevamount' => $this->prevamount]);
        
    }
}
