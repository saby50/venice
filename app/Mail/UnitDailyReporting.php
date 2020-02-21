<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnitDailyReporting extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($amount,$refund,$net_amount,$number_transactions,$refund_count,$unit_name,$unit_email)
    {
        $this->amount = $amount;
        $this->refund = $refund;
        $this->net_amount = $net_amount;
        $this->number_transactions = $number_transactions;
        $this->refund_count = $refund_count;
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
                 ->subject($this->unit_name." Wallet Report! (".date('d/m/Y').")")
                ->view('unitreportdaily')
                ->with(['amount' => $this->amount,'refund' => $this->refund,'net_amount' => $this->net_amount,'number_transactions' => $this->number_transactions,'refund_count' => $this->refund_count ,'unit_name' => $this->unit_name,
                    'unit_email' => $this->unit_email]);
    }
}
